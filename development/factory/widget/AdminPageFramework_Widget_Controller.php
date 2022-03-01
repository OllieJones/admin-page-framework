<?php
/**
 * Admin Page Framework
 *
 * http://admin-page-framework.michaeluno.jp/
 * Copyright (c) 2013-2022, Michael Uno; Licensed MIT
 *
 */

/**
 * Provides methods of views for the widget factory class.
 *
 * Those methods are public and provides means for users to set property values.
 *
 * @abstract
 * @since       3.2.0
 * @package     AdminPageFramework/Factory/Widget
 */
abstract class AdminPageFramework_Widget_Controller extends AdminPageFramework_Widget_View {

    /**
    * The method for necessary set-ups.
    *
    * <h4>Example</h4>
    * <code>
    *   public function setUp() {
    *       $this->setArguments(
    *           array(
    *               'description'   =>  __( 'This is a sample widget with built-in field types created by Admin Page Framework.', 'admin-page-framework-demo' ),
    *           )
    *       );
    *   }
    * </code>
    *
    * @abstract
    * @since        3.2.0
    */
    public function setUp() {}

    /**
     * The method for setting up form elements.
     *
     * <h4>Example</h4>
     * <code>
     *  public function load( $oAdminWidget ) {
     *
     *      $this->addSettingFields(
     *          array(
     *              'field_id'      => 'title',
     *              'type'          => 'text',
     *              'title'         => __( 'Title', 'admin-page-framework-demo' ),
     *              'default'       => 'Hi there!',
     *          ),
     *          array(
     *              'field_id'      => 'repeatable_text',
     *              'type'          => 'text',
     *              'title'         => __( 'Text Repeatable', 'admin-page-framework-demo' ),
     *              'repeatable'    => true,
     *              'sortable'      => true,
     *          ),
     *          array(
     *              'field_id'      => 'textarea',
     *              'type'          => 'textarea',
     *              'title'         => __( 'Text Area', 'admin-page-framework-demo' ),
     *          ),
     *          array(
     *              'field_id'      => 'checkbox',
     *              'type'          => 'checkbox',
     *              'title'         => __( 'Check Box', 'admin-page-framework-demo' ),
     *              'label'         => __( 'This is a check box in a widget form.', 'admin-page-framework-demo' ),
     *          ),
     *          array(
     *              'field_id'      => 'radio',
     *              'type'          => 'radio',
     *              'title'         => __( 'Radio Buttons', 'admin-page-framework-demo' ),
     *              'label'         => array(
     *                  'one'   =>  __( 'One', 'admin-page-framework-demo' ),
     *                  'two'   =>  __( 'Two', 'admin-page-framework-demo' ),
     *                  'three' =>  __( 'Three', 'admin-page-framework-demo' ),
     *              ),
     *              'default'       => 'two',
     *          ),
     *          array(
     *              'field_id'      => 'select',
     *              'type'          => 'select',
     *              'title'         => __( 'Dropdown', 'admin-page-framework-demo' ),
     *              'label'         => array(
     *                  'i'     =>  __( 'I', 'admin-page-framework-demo' ),
     *                  'ii'    =>  __( 'II', 'admin-page-framework-demo' ),
     *                  'iii'   =>  __( 'III', 'admin-page-framework-demo' ),
     *              ),
     *          ),
     *          array(
     *              'field_id'      => 'image',
     *              'type'          => 'image',
     *              'title'         => __( 'Image', 'admin-page-framework-demo' ),
     *          ),
     *          array(
     *              'field_id'      => 'media',
     *              'type'          => 'media',
     *              'title'         => __( 'Media', 'admin-page-framework-demo' ),
     *          ),
     *          array(
     *              'field_id'      => 'color',
     *              'type'          => 'color',
     *              'title'         => __( 'Color', 'admin-page-framework-demo' ),
     *          ),
     *          array()
     *      );
     *
     *  }
     * </code>
     * @since       3.2.0
     * @since       3.8.14      Deprecated the first parameter.
     * @todo        Document the difference between this method and `setUp()` and why the user should use this method to register form elements.
     */
    public function load() {}

    /**
     * Sets the widget arguments.
     *
     * This is only necessary if it is not set in the constructor.
     *
     * @since       3.2.0
     * @param       array       $aArguments     Widget arguments same as the one passed to the 4th parameter of the `wp_register_sidebar_widget()` function.
     * <h4>Arguments<h4>
     * <ul>
     *      <li>`classname` - (string) A class selector name for the widget's HTML container element.</li>
     *      <li>`description` - (string) A widget description displayed in the widget administration and theme panel.</li>
     * </ul>
     * @see         https://codex.wordpress.org/Function_Reference/wp_register_sidebar_widget
     * @return      void
     */
    protected function setArguments( array $aArguments=array() ) {
        $this->oProp->aWidgetArguments = $aArguments;
    }

}