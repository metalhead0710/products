!(function ($) {
    "use strict";

    var Products = {

        options: {},

        init: function (options, root) {

            this.root = $(root);
            this.options = $.extend({}, this.options, options);
			this.fileName = this.root.find(".file-name");
			this.fileInput = this.root.find("#fileinput");


            // Bind handlers
            this.bindHandlers();           
        },
		
		

        bindHandlers: function () {
            var self = this;

			this.fileInput.on('change', function() {
                self.fileName.html(this.files[0].name);
            });
        },
    };

    App.Page.Products = function (options, root) {
        root = root || $("body");

        root = $(root)[0];
        if (!$.data(root, "_Products")) {
            $.data(root, "_Products", Object.create(Products).init(options, root));
        }
        return $.data(root, "_Products");
    };
})(jQuery);