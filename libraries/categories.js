$( document ).ready( function() {

    let root_url = './../api/';

    let current_category = {};

    get_categories();

    function clear_error_messages() {
        $( '.form-group' ).removeClass( 'has-danger' ); // remove the has-danger class from all form groups
        $( '.text-danger' ).remove(); // remove the error message and error message class from all form controls
        $( '#error_message' ).children().remove(); // clear the error_message div
    }

    function display_error( display_element, error ) {
        display_element.addClass( 'has-danger' );
        display_element.append( '<div class="form-text text-danger">' + error + '</div>' );
    }

    function disable_button() {
        $( '#btnSave' ).prop( 'disabled', true );
    }

    function enable_button() {
        $( '#btnSave' ).prop( 'disabled', false );
    }
    
    function get_categories() {
        $.ajax({
            url         : root_url + 'categories',
            dataType    : 'json',
            method      : 'GET',
            success     : function ( data ) {

                let element = $( '#categories' );

                element.DataTable().clear();

                element.DataTable({
                    "data"          : data,
                    "destroy"       : true,
                    columns         : [
                        { title     : "Category name" },
                        { title     : "&nbsp;" }
                    ], columns      : [
                        { "data"    : "category_name" },
                        {
                            "mRender": function( data, type, row ) {
                                return '<button class=".btn btn-edit" id="' + row.category_id + '"><i class="fas fa-pencil-alt">' +
                                    '</i> Edit</button>';
                            }
                        }
                    ]
                });

            }, error    : function ( xhr, type ) {
                console.log( xhr, type );
            }
        });

    }

    $( document ).on( 'click', '.btn-edit', function () {
        let category_id = $( this ).attr( "id" );

        $.ajax({
            url         : root_url + 'categories/' + category_id,
            method      : 'GET',
            dataType    : 'json',
            success     : function ( data ) {

                current_category = data;

                show_category_details( current_category );

            }, error    : function ( xhr, type ) {
                console.log( xhr, type );
            }
        });

    }) ;

    function show_category_details ( category ) {
        if ( $.isEmptyObject( category ) ) {
            $( '#category_id' ).val( '' );
            $( '#category' ).val( '' );
        } else {
            $( '#category_id' ).val( category.category_id );
            $( '#category' ).val( category.category_name );
        }
    }

    function add_category() {
        let form_data = $( '#category_details' ).serializeArray();

        $.ajax({
            url         : root_url + 'category',
            method      : 'POST',
            dataType    : 'json',
            data        : form_data,
            success     : function ( data ) {

                if ( !data.success ) {

                    if ( data.errors.category ) {
                        let element = $( '#category_grp' );
                        display_error( element, data.errors.category );
                    }

                    if ( data.errors.database ) {
                        $( '#error_message' ).append( '<div class="alert alert-danger alert-dismissible fade show">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span ' +
                            'aria-hidden="true">&times;</span></button>' + data.errors.database + '</div>' );
                    }

                } else {
                    $( '#error_message' ).append( '<div class="alert alert-success alert-dismissible fade show">' +
                        '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span ' +
                        'aria-hidden="true">&times;</span></button>' + data.message + '</div>' );
                    get_categories();
                    current_category = {};
                    show_category_details( current_category );
                }

            }, error    : function ( xhr, type ) {
                console.log( xhr, type );
            }
        });

        enable_button();

    }

    function edit_category() {
        let form_data = $( '#category_details' ).serializeArray();

        $.ajax({
            url         : root_url + 'category/' + $( '#category_id' ).val(),
            method      : 'PUT',
            dataType    : 'json',
            data        : form_data,
            success     : function ( data ) {

                if ( !data.success ) {

                    if ( data.errors.category ) {
                        let element = $( '#category_grp' );
                        display_error( element, data.errors.category );
                    }

                    if ( data.errors.database ) {
                        $( '#error_message' ).append( '<div class="alert alert-danger alert-dismissible fade show">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span ' +
                            'aria-hidden="true">&times;</span></button>' + data.errors.database + '</div>' );
                    }

                } else {
                    $( '#error_message' ).append( '<div class="alert alert-success alert-dismissible fade show">' +
                        '<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span ' +
                        'aria-hidden="true">&times;</span></button>' + data.message + '</div>' );
                    get_categories();
                    current_category = {};
                    show_category_details( current_category );
                }

            }, error    : function ( xhr, type ) {
                console.log( xhr, type );
            }
        });

        enable_button();

    }

    $( '#category_details' ).submit( function () {
        clear_error_messages();
        disable_button();

        if ( $( '#category_id' ).val() === "" ) {
            add_category();
        } else {
            edit_category();
        }

        return false;

    });

});