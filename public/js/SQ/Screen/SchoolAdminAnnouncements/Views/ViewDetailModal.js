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

		return function ViewDetailModal() {

			var _me = this;
			var _$view_detail_modal = null;
			var _util = new Util();

			SQ.mixin(_me, new Broadcaster());

			(function _init() {
			})();

			this.initialize = function($e) {
				_$view_detail_modal = $e;
			};

			this.show = function() {
				_$view_detail_modal.modal('show');
			};

			this.hide = function() {
				_$view_detail_modal.modal('hide');
			};

			this.setModalTitle = function(title) {
				_$view_detail_modal.find('.modal-title').text(title);
			};

			this.setContent = function(data) {
				var _start_date = new Date(_util.utcToLocal(data.start_date.date));
				var _end_date = new Date(_util.utcToLocal(data.end_date.date));

				_$view_detail_modal.find('.start-date').text(_start_date.getDate() + '/' + (_start_date.getMonth()+1) + '/' + _start_date.getFullYear());
				_$view_detail_modal.find('.end-date').text(_end_date.getDate() + '/' + (_end_date.getMonth()+1) + '/' + _end_date.getFullYear());
				_$view_detail_modal.find('.title').text(data.title);
				_$view_detail_modal.find('.content').text(data.content);

			};

		};
	}
);
