	<footer class="admin-footer">
		<div class="row">
			<div class="col-xs-6 left">
				Copyright &copy; 2016 - <?=date('Y')?>. Squl.io
			</div>
			<div class="col-xs-6 right">
				<a class="contact-squlio">Contact Squlio</a>
			</div>
		</div>
	</footer>
	<? if(!empty($footerJs)) : ?>
		<? foreach($footerJs as $js) : ?>
			<script type="text/javascript" src="<?=$js?>"></script>
		<? endforeach; ?>
	<? endif; ?>
	<? if ($minified_js) : ?>
		<script src="<?=$js_path?>/third_party/require_optimized.js"></script>
	<? else: ?>
		<script src="<?=$js_path?>/third_party/require.js"></script>
	<? endif; ?>
	<script>
		<? if (isset($jsControllerParam) && $jsControllerParam) : ?>
			var jsControllerParam = <?=$jsControllerParam?>;
		<? else: ?>
			var jsControllerParam = false;
		<? endif; ?>
	</script>
	<script>
		require.config({
            baseUrl: '<?=$js_path?>',
            paths: {
                'SQ': '<?=$js_path?>/SQ',
                'ThirdParty': '<?=$js_path?>/third_party',
                'Global': '<?=$js_path?>',
                'jquery': '<?=$js_path?>/third_party/jquery-3.1.1.min',
				'bootstrap': '<?=$js_path?>/third_party/bootstrap',
                'underscore': '<?=$js_path?>/third_party/underscore',
				'jgrowl': '<?=$js_path?>/third_party/jquery.jgrowl.min',
				'jqueryui': '<?=$js_path?>/third_party/jquery-ui.min',
				'datatables': '<?=$js_path?>/third_party/jquery.dataTables.min',
                'text': '<?=$js_path?>/third_party/text',
				<? if (isset($requireJsDataSource) && $requireJsDataSource) : ?>
					<? if ($minified_js) : ?>
						'<?=$requireJsDataSource?>_optimized': '<?=$js_path?>/sq_js/<?=$requireJsDataSource?>_optimized'
					<? else : ?>
						'<?=$requireJsDataSource?>': '<?=$js_path?>/sq_js/<?=$requireJsDataSource?>'
					<? endif; ?>
				<? endif; ?>
            },
            shim: {
                'underscore': {
                    exports: '_'
                },
				'bootstrap': {
					deps: ['jquery']
				},
				'jgrowl': {
					deps: ['jquery']
				},
				'jqueryui': {
					deps: ['jquery']
				},
				'datatables': {
					deps: ['jquery']
				}

            }
        });

		<? if (isset($requireJsDataSource) && $requireJsDataSource) : ?>
			<? if ($minified_js) : ?>
		require(['<?=$requireJsDataSource?>_optimized']);
			<? else : ?>
		require(['<?=$requireJsDataSource?>']);
			<? endif; ?>
		<? endif; ?>


		require(['jquery'], function($) {
			_fixedFooter();
			$(window).resize(function() {
				_fixedFooter();
			});

			function _fixedFooter() {
				var _window_height = $(window).height();
				var _sq_container_height = $('.sq-container').height();
				var _navbar_height = $('nav.navbar').height();
				if (_navbar_height + _sq_container_height + 100 > _window_height) {
					$('footer').css('position', 'relative');
				} else {
					$('footer').css('position', 'absolute');
				}
			}
		});
	</script>
