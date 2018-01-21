$(document).ready(function () {

    document.querySelectorAll( '#article_text' )
        .forEach(function(el){
            el.removeAttribute('required');
            ClassicEditor
                .create( el, {
                    // toolbar: [ 'headings', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                    ckfinder: {
                        uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
                    }
                } )
                .then( function (editor) {
                    console.log( editor );
                    const div = el.parentNode.querySelector('.ck-editor__editable');
                    div.style.backgroundColor = 'white';
                    div.style.minHeight = '300px';
                } )
                .catch( function (error) {
                    console.error( error );
                } );
        });
});
