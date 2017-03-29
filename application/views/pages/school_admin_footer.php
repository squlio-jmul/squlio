<footer class="school-admin-footer">
		<p class="copyright">&copy; <?=date('Y')?> Squlio - All rights reserved.</p>
		<a href="#">Contact Squlio</a>
	</footer>
	<? if ($minified_js) : ?>
		<script src="<?=$js_path?>/third_party/require_optimized.js"></script>
	<? else: ?>
		<script src="<?=$js_path?>/third_party/require.js"></script>
	<? endif; ?>

	<? if(!empty($footerJs)) : ?>
		<? foreach($footerJs as $js) : ?>
			<script type="text/javascript" src="<?=$js?>"></script>
		<? endforeach; ?>
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
	</script>
