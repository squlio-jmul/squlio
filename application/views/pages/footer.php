	<footer>
		<div class="container-fluid">
			<div class="row">
				<ul class="footer-links">
					<li><a href="/support/about" target="_blank">About Us</a></li>
					<li><a href="/support/conditions" target="_blank">Conditions of Use</a></li>
					<li><a href="/support/privacy" target="_blank">Privacy Policy</a></li>
				</ul>
				<p class="copyright">&copy; <?=date('Y')?> Squlio - All rights reserved.</p>
			</div>
		</div>
	</footer>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
                'jquery': '<?=$js_path?>/third_party/jquery.min',
				'bootstrap': '<?=$js_path?>/third_party/bootstrap',
                'underscore': '<?=$js_path?>/third_party/underscore',
                'text': '<?=$js_path?>/third_party/text',
				<? if (isset($requireJsDataSource) && $requireJsDataSource) : ?>
					<? if ($minified_js) : ?>
						'<?=$requireJsDataSource?>_optimized': '<?=$js_path?>/bw_js/<?=$requireJsDataSource?>_optimized'
					<? else : ?>
						'<?=$requireJsDataSource?>': '<?=$js_path?>/bw_js/<?=$requireJsDataSource?>'
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
