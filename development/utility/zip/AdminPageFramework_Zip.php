<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2021, Michael Uno; Licensed MIT
 *
 */

/**
 * Compresses files into a zip file.
 *
 * <h3>Usage</h3>
 * Pass a source directory/file path to the first parameter and a destination directory path to the second parameter.
 * Then use the `compress()` method to perform archiving.
 *
 * <h3>Example</h3>
 * <code>
 * $_oZip     = new AdminPageFramework_Zip( $sSourcePath, $sDestinationPath );
 * $_bSucceed = $_oZip->compress();
 * </code>
 *
 * @since       3.5.4
 * @package     AdminPageFramework/Utility
 */
class AdminPageFramework_Zip {

    /**#@+
     * @internal
     */
    /**
     * Stores a source directory/file path.
     */
    public $sSource;

    /**
     * Stores a destination path of the target zip file.
     *
     * e.g. '/my_dir/myscript.zip'
     */
    public $sDestination;


    /**
     * Stores a callable that gets applied to parsing file string contents.
     */
    public $aCallbacks = array(
        'file_name'                     => null,
        'file_contents'                 => null,
        'directory_name'                => null,
    );

    /**
     * Stores settings.
     *
     * @since       3.6.0
     */
    public $aOptions   = array(
        'include_directory'             => false,   // (boolean) whether the contents should be put inside a root directory.
        'additional_source_directories' => array(),
        // 'ignoring_file_extensions'      => array(), // not implemented yet.
    );
    /**#@-*/

    /**
     * Sets up properties.
     *
     * @param       string              $sSource
     * @param       string              $sDestination
     * @param       array|boolean       $abOptions
     * @param       callable            $aCallbacks
     */
    public function __construct( $sSource, $sDestination, $abOptions=false, array $aCallbacks=array() ) {

        $this->sSource      = $sSource;
        $this->sDestination = $sDestination;
        $this->aOptions     = $this->_getFormattedOptions( $abOptions );
        $this->aCallbacks   = $aCallbacks + $this->aCallbacks;

    }
        /**
         * Formats the option array.
         *
         * @remark      if a boolean value is passed to the first parameter, it will be assigned to the `include_directory` element.
         * @return      array       The formatted option array.
         * @internal
         */
        private function _getFormattedOptions( $abOptions ) {
            $_aOptions = is_array( $abOptions )
                ? $abOptions
                : array(
                    'include_directory' => $abOptions,
                );
            return $_aOptions + $this->aOptions;
        }

    /**
     * Performs zip file compression.
     *
     * @since       3.5.4
     * @return      boolean      True on success; false otherwise.
     */
    public function compress() {

        // Check whether it is possible to perform the task.
        if ( ! $this->isFeasible( $this->sSource ) ) {
            return false;
        }

        // Delete the existing file / directory.
        if ( file_exists( $this->sDestination ) ) {
            unlink( $this->sDestination );
        }

        $_oZip = new ZipArchive();
        if ( ! $_oZip->open( $this->sDestination, ZIPARCHIVE::CREATE ) ) {
            return false;
        }

        $this->sSource = $this->_getSanitizedSourcePath( $this->sSource );

        $_aCallbacks    = array(
            'unknown'   => '__return_false',
            'directory' => array( $this, '_replyToCompressDirectory' ),
            'file'      => array( $this, '_replyToCompressFile' ),
        );
        return call_user_func_array(
            $_aCallbacks[ $this->_getSourceType( $this->sSource ) ],
            array(
                $_oZip,
                $this->sSource,
                $this->aCallbacks,
                $this->aOptions[ 'include_directory' ],
                $this->aOptions[ 'additional_source_directories' ],
            )
        );

    }
        /**
         * @since       3.6.0
         * @return      string
         * @internal
         */
        private function _getSanitizedSourcePath( $sPath ) {
            return str_replace( '\\', '/', realpath( $sPath ) );
        }
        /**
         *
         * @since       3.5.4
         * @since       3.6.0       Changed the name from `_compressDirectory`. Changed the scope to public to allow overriding the method in an extended class.
         * @return      boolean     True on success, false otherwise.
         * @internal
         */
        public function _replyToCompressDirectory( ZipArchive $oZip, $sSourceDirPath, array $aCallbacks=array(), $bIncludeDir=false, array $aAdditionalSourceDirs=array() ) {

            $_sArchiveRootDirName = '';

            if ( $bIncludeDir ) {
                $_sArchiveRootDirName = $this->_getMainDirectoryName( $sSourceDirPath );
                $this->_addEmptyDir(
                    $oZip,
                    $_sArchiveRootDirName,
                    $aCallbacks[ 'directory_name' ]
                );
            }

            array_unshift( $aAdditionalSourceDirs, $sSourceDirPath );
            $_aSourceDirPaths = array_unique( $aAdditionalSourceDirs );

            $this->_addArchiveItems(
                $oZip,
                $_aSourceDirPaths,
                $aCallbacks,
                $_sArchiveRootDirName
            );

            return $oZip->close();

        }
            /**
             * @since       3.6.0
             * @return      void
             * @internal
             */
            private function _addArchiveItems( $oZip, $aSourceDirPaths, $aCallbacks, $sRootDirName='' ) {

                $sRootDirName = $sRootDirName ? rtrim( $sRootDirName, '/' ) . '/' : '';

                foreach( $aSourceDirPaths as $_isIndexOrRelativeDirPath => $_sSourceDirPath ) {

                    $_sSourceDirPath   = $this->_getSanitizedSourcePath( $_sSourceDirPath );
                    $_sInsideDirPrefix = is_integer( $_isIndexOrRelativeDirPath )
                        ? ''
                        : $_isIndexOrRelativeDirPath;

                    // Add a directory inside the compressing directory.
                    if( $_sInsideDirPrefix ) {
                        $this->_addRelativeDir(
                            $oZip,
                            $_sInsideDirPrefix,
                            $aCallbacks[ 'directory_name' ]
                        );
                    }

                    $_oFilesIterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator( $_sSourceDirPath ),
                        RecursiveIteratorIterator::SELF_FIRST
                    );
                    foreach ( $_oFilesIterator as $_sIterationItem ) {
                        $this->_addArchiveItem(
                            $oZip,
                            $_sSourceDirPath,
                            $_sIterationItem,
                            $aCallbacks,
                            $sRootDirName . $_sInsideDirPrefix
                        );
                    }
                }

            }
                /**
                 * @since       3.6.0
                 * @return      void
                 * @internal
                 */
                private function _addRelativeDir( $oZip, $sRelativeDirPath, $oCallable ) {
                    $sRelativeDirPath = str_replace( '\\', '/', $sRelativeDirPath );
                    $_aPathPartsParse = array_filter( explode( '/', $sRelativeDirPath ) );
                    $_aDirPath        = array();
                    foreach( $_aPathPartsParse as $_sDirName ) {
                        $_aDirPath[] = $_sDirName;
                        $this->_addEmptyDir(
                            $oZip,
                            implode( '/', $_aDirPath ),
                            $oCallable
                        );
                    }
                }
                /**
                 * Adds an item (directory or file) to the archive.
                 *
                 * @since       3.5.4
                 * @param       ZipArchive      $oZip                   The performing Zip archive object.
                 * @param       string          $sSource                The source directory path.
                 * @paran       string          $_sIterationItem        The iteration item path.
                 * @param       array           $aCallbacks             An array holding callbacks.
                 * @param       string          $sInsidePathPrefix      The prefix to add to the inside archive directory structure.
                 * @return      void
                 * @internal
                 */
                private function _addArchiveItem( ZipArchive $oZip, $sSource, $_sIterationItem, array $aCallbacks, $sInsidePathPrefix='' ) {

                    $_sIterationItem   = str_replace( '\\', '/', $_sIterationItem );
                    $sInsidePathPrefix = rtrim( $sInsidePathPrefix, '/' ) . '/'; // add a trailing slash

                    // Ignore "." and ".." folders
                    if (
                        in_array(
                            substr( $_sIterationItem, strrpos( $_sIterationItem, '/' ) + 1 ),
                            array( '.', '..' )
                       )
                    ) {
                        return;
                    }

                    $_sIterationItem = realpath( $_sIterationItem );
                    $_sIterationItem = str_replace( '\\', '/', $_sIterationItem );

                    if ( true === is_dir( $_sIterationItem ) ) {
                        $this->_addEmptyDir(
                            $oZip,
                            $sInsidePathPrefix . str_replace(
                                $sSource . '/',
                                '',
                                $_sIterationItem . '/'
                            ),
                            $aCallbacks[ 'directory_name' ]
                        );
                    } else if ( true === is_file( $_sIterationItem ) ) {
                        $this->_addFromString(
                            $oZip,
                            $sInsidePathPrefix . str_replace(
                                $sSource . '/',
                                '',
                                $_sIterationItem
                            ),
                            file_get_contents( $_sIterationItem ),
                            $aCallbacks
                        );
                    }

                }

            /**
             *
             * @since       3.5.4
             * @remark      Assumes the path is sanitized.
             * @return      string      The main directory base name.
             * @internal
             */
            private function _getMainDirectoryName( $sSource ) {
                $_aPathParts = explode( "/", $sSource );
                return $_aPathParts[ count( $_aPathParts ) - 1 ];
            }

        /**
         * Compresses a file.
         * @since       3.5.4
         * @since       3.6.0       Changed the name from `_compressFile`. Changed the scope from `private` to allow overriding in an extended class.
         * @return      boolean     True on success, false otherwise.
         * @internal
         */
        public function _replyToCompressFile( ZipArchive $oZip, $sSourceFilePath, $aCallbacks=null ) {
            $this->_addFromString(
                $oZip,
                basename( $sSourceFilePath ),
                file_get_contents( $sSourceFilePath ),
                $aCallbacks
            );
            return $oZip->close();
        }

    /**
     *
     * @return      string      'directory' or 'file' or 'unknown'
     * @internal
     */
    private function _getSourceType( $sSource ) {

        if ( true === is_dir( $sSource ) ) {
            return 'directory';
        }
        if ( true === is_file( $sSource ) ) {
            return 'file';
        }
        return 'unknown';

    }
    /**
     * Checks if the action of compressing files is feasible.
     * @since       3.5.4
     * @return      boolean
     * @internal
     */
    private function isFeasible( $sSource ) {
        if ( ! extension_loaded( 'zip' ) ) {
            return false;
        }
        return file_exists( $sSource );
    }

    /**
     * Add an empty directory to an archive.
     *
     * @since       3.5.4
     * @remark      If the path is empty, it will not process.
     * @return      void
     * @internal
     */
    private function _addEmptyDir( ZipArchive $oZip, $sInsidePath, $oCallable ) {
        $sInsidePath = $this->_getFilteredArchivePath( $sInsidePath, $oCallable );
        if ( ! strlen( $sInsidePath ) ) {
            return;
        }
        $oZip->addEmptyDir( ltrim( $sInsidePath, '/' ) );
    }
    /**
     * Adds a file to an archive by applying a callback to the read file contents.
     *
     * @since       3.5.4
     * @remark      If the path is empty, it will not process.
     * @return      void
     * @internal
     */
    private function _addFromString( ZipArchive $oZip, $sInsidePath, $sSourceContents='', array $aCallbacks=array() ) {

        $sInsidePath = $this->_getFilteredArchivePath( $sInsidePath, $aCallbacks[ 'file_name' ] );
        if ( ! strlen( $sInsidePath ) ) {
            return;
        }
        $oZip->addFromString(
            ltrim( $sInsidePath, '/' ),
            is_callable( $aCallbacks[ 'file_contents' ] )
                ? call_user_func_array(
                    $aCallbacks[ 'file_contents' ],
                    array(
                        $sSourceContents,
                        $sInsidePath
                    )
                )
                : $sSourceContents
        );

    }

    /**
     * Retrieves a filtered archive path.
     * @since       3.5.4
     * @return      string
     * @internal
     */
    private function _getFilteredArchivePath( $sArchivePath, $oCallable ) {
        return is_callable( $oCallable )
            ? call_user_func_array(
                $oCallable,
                array(
                    $sArchivePath,
                )
            )
            : $sArchivePath;
    }

}
