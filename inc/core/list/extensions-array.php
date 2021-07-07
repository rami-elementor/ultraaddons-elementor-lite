<?php

use Elementor\Controls_Manager;
/**
 * List of Extension.
 * 
 * All of Supported widget will add here as array.
 * 
 * 
 * @author Saiful
 */


$extensionsArray = [
            'Wrapper_Link'=> [
                    'name'      => __( 'Wrapper Link', 'ultraaddons' ),
                    'is_pro'   => false,
                    'icon'      => 'uicon-button',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
            ],


            'Hover_Effect' => [
                    'name'  => __( 'Hover Effect', 'ultraaddons' ),
                    'is_pro'   => false,
                    'icon'      => 'uicon-hover',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
            ],
            
            /**
             * CSS Transform Editing for
             * Any content/any element/
             * We will added this Extenstion at V1.0.3.0
             * 
             * @date 4.3.2021
             * @since 1.0.3.0
             */
            'Transform' => [
                    'name'  => __( 'CSS Transform', 'ultraaddons' ),
                    'is_pro'   => true,
                    'icon'      => 'eicon-heading',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
                    'tab' => Controls_Manager::TAB_STYLE, //This is only for PlaceHolder Extension. showing message on free user
            ],
            

            'Animation_Effect' => [
                    'name'  => __( 'Animation Effect', 'ultraaddons' ),
                    'is_pro'   => true,
                    'icon'      => 'eicon-code-highlight',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
                    'tab' => Controls_Manager::TAB_STYLE,  //This is only for PlaceHolder Extension. showing message on free user
            ],

            'Background_Overlay' => [
                    'name'  => __( 'Background Overlay', 'ultraaddons' ),
                    'is_pro'   => false,
                    'icon'      => 'eicon-background',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
            ],

            'Ultra_Effect' => [
                    'name'  => __( 'Ultra Effect', 'ultraaddons' ),
                    'is_pro'   => true,
                    'icon'      => 'eicon-spinner',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
            ],

            'Gradient_Text' => [
                    'name'  => __( 'Gradient Text', 'ultraaddons' ),
                    'is_pro'   => false,
                    'icon'      => 'eicon-global-colors',
                    'cat'       => [
                        __( 'Basic', 'ultraaddons' ),
                    ],
            ],

//         Need more Customizer and to be update   
//            'ultra-effects'=> [
//                    'name'  => __( 'Ultra Effect', 'ultraaddons' ),
//            ],
            
        ];

return apply_filters( 'ultraaddons/extensions/array', $extensionsArray );