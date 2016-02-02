var ThinkbigUploader = (function () {

    var instances = {},

    initUploader = function() { 

        $("[data-form-type='file_resource']").each(function(){

            var settings = { maxFilesize: 2, maxFiles: 1 };
            
            // add the "add a tag" anchor and li to the tags ul
            //addLink.clone().appendTo($(this));

            // count the current form inputs we have (e.g. 2), use that as the new
            // index when inserting a new item (e.g. 2)
            $(this).data('index', $(this).find(':input').length);
/*
            $(this).find('.add_link').on('click', function(e) {
                // prevent the link from creating a "#" on the URL
                e.preventDefault();

                // add a new tag form (see next code block)
                addField($(e.data.collectionHolder), e.target);

            });
*/

            if (maxFiles = $(this).data('max-files')) {

                settings.maxFiles = maxFiles;

            }

            if (maxFilesize = $(this).data('max-size')) {

                settings.maxFilesize = maxFilesize;

            }

            console.log(settings)

            initDropzone(this, settings);

        })

    },
    initDropzone = function(el, options) {

        var element     = '#' + $(el).attr('id') + '_zone';
        var iname        = $(el).attr('id');

        instances[iname]  = new Dropzone(element, {
            url: Routing.generate('dropzone_upload'),
            paramName: "file_resource", // The name that will be used to transfer the file
            maxFilesize: options.maxFilesize, // MB
            addRemoveLinks: true,
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 100,
            maxFiles: options.maxFiles,
            previewsContainer: element + ' .dropzone-previews',
            clickable: element + ' .dropzone-plus',
            //params: {  id: 123 },
            
            accept: function(file, done) {

                // check file types.

                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                }
                else { done(); }

            },
            maxfilesexceeded: function(file) { this.removeFile(file); },
            success: function(file, response) {

                addField($(el), response.fileName);

                file.server_id = response.fileName;


            }
        })
        .on("removedfile", function(file) {
            
            console.log(this.options.maxFiles)
            if (file.saved) {
                this.options.maxFiles += 1;

            }
            
            removeField(file.server_id);

            console.log(this.options.maxFiles)
            console.log(this.files)

            if (this.options.maxFiles > this.files.length) {

                plus.show();
                
            }

        })
        .on("addedfile", function(file) {

            plus = $(element + ' .dropzone-plus');

            plus.parent().append(plus);

            console.log(this.options.maxFiles + '  ' + this.files.length);

            if (this.options.maxFiles <= this.files.length) {

                plus.hide();

            }



        });


    },
    addField = function(collectionHolder, data) {

        if (typeof data === "undefined") data = "";

        // Get the data-prototype explained earlier
        var prototype = collectionHolder.data('prototype');

        // get the new index
        var index = collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var row = $("<div></div>").append(prototype.replace(/__name__/g, index));

        $(row).find('input').val(data);
        $(row).find('input').attr('id', data);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        $(collectionHolder).append(row);

    },
    removeField = function(uid) {

        $.ajax({
            url: Routing.generate('dropzone_remove', {'uid' : uid}), 
            success: function(result){

                console.log("[data-target='"+ uid +"']");
                
                $("#"+ uid ).remove();

            }
        });


    },
    addFile = function(instance, uid, path) {

        var dropzone = instances[instance];

        var mockFile = { name: "Filename", size: 12345, server_id: uid, saved: true };

        dropzone.options.maxFiles = dropzone.options.maxFiles - 1;

        // Call the default addedfile event handler
        dropzone.emit("addedfile", mockFile);

                // And optionally show the thumbnail of the file:
        dropzone.emit("thumbnail", mockFile, path);

                // Make sure that there is no progress bar, etc...
        dropzone.emit("complete", mockFile);

                // If you use the maxFiles option, make sure you adjust it to the
                // correct amount:
                //var existingFileCount = 1; // The number of files already uploaded

    };

    return {
        init: initUploader,
        add: addField,
        addFile: addFile
    }
})(); 