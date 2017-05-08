define(
	[
		'jquery',
		'Global/SQ',
		'SQ/Broadcaster',
		'SQ/Util'
	],
	function(
		$,
		SQ,
		Broadcaster,
		Util
	) {

		'use_strict';

		return function DeleteModal() {

			var _me = this;
			var _$delete_modal = null;
			var _util = new Util();

			SQ.mixin(_me, new Broadcaster(['delete_announcement']));

			(function _init() {
			})();

			this.initialize = function($e) {
				_$delete_modal = $e;
				$e.find('.delete-announcement').on('click', function() {
					_me.broadcast('delete_announcement');
				});
			};

			this.show = function() {
				_$delete_modal.modal('show');
			};

			this.hide = function() {
				_$delete_modal.modal('hide');
			};

		};
	}
);
