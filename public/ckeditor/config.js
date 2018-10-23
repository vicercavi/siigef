/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	  config.filebrowserBrowseUrl = _root_ +'public/ckeditor/kcfinder/browse.php';	
    config.filebrowserImageBrowseUrl = _root_+'public/ckeditor/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = _root_+'public/ckeditor/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = _root_+'public/ckeditor/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = _root_+'public/ckeditor/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = _root_+'public/ckeditor/kcfinder/upload.php?type=flash';
};
/*
CKEDITOR.editorConfig = function(config) {
// ...
   config.filebrowserBrowseUrl = 'kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = 'kcfinder/upload.php?&type=files';
   config.filebrowserImageUploadUrl = 'kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = 'kcfinder/upload.php?type=flash';
// ...
};
*/