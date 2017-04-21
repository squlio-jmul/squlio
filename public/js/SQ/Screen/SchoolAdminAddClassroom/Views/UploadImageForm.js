define([
	'jquery',
	'Global/SQ',
	'SQ/Broadcaster',
	'SQ/Util'
], function(
	$,
	SQ,
	Broadcaster,
	Util
) {

	'use_strict';

	return function UploadImageForm() {

		var _me = this;
		var _$upload_image_form = null;
		var _nbUtil = new Util();
		var _has_uploaded = false;

		SQ.mixin(_me, new Broadcaster(['upload_image']));

		(function _init() {
		})();

		this.initialize = function($e) {
			_$upload_image_form = $e;
			_setListeners($e);
		};

		this.updateImage = function(url_path) {
			_$upload_image_form.find('.image-preview-container').css('background-image', 'url(' + url_path + ')');
			_$upload_image_form.find('label.error').remove();
			_$upload_image_form.find('[name="image_file"]').val('');
			_$upload_image_form.find('.image-preview-container').removeClass('hidden').fadeIn(300);
			_$upload_image_form.find('.add-image-container, .upload-image-form-container').hide();
			_has_uploaded = true;
		};

		function _setListeners($e) {
			$e.find('.add-image-container, .image-preview-container').on('click', function() {
				$e.find('.upload-image-form-container').removeClass('hidden').fadeIn(300);
				$(this).hide();
			});
			$e.find('.upload').on('click', function() {
				var _data = new FormData();
				_$upload_image_form.find('label.error').remove();
				if (!_$upload_image_form.find('[name="image_file"]').val()) {
					_$upload_image_form.find('[name="image_file"]').after('<label for="image_file" class="error">This field is required.</label>');
					return false;
				}
				_data.append('file', _$upload_image_form.find('[name="image_file"]').prop('files')[0]);
				_me.broadcast('upload_image', _data);
			});
			$e.find('.cancel').on('click', function(e) {
				e.preventDefault();
				$(e.target).closest('.upload-image-form-container').hide();
				if (_has_uploaded) {
					$e.find('.image-preview-container').fadeIn(300);
				} else {
					$e.find('.add-image-container').fadeIn(300);
				}
			});
		}
	};
});
