<div id="sq-school-admin-messages-container">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#incoming" aria-controls="incoming" role="tab" data-toggle="tab">Incoming Messages <span class="badge num-messages <?=($num_new_message ? '' : 'sq-hidden')?>"><?=$num_new_message?></span></a></li>
		<li role="presentation"><a href="#outgoing" aria-controls="outgoing" role="tab" data-toggle="tab">Outgoing Messages</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="incoming">
			<table id="incoming-messages" class="table table-striped table-hover" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>From</th>
						<th>Body</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="sq-view-message-container sq-hidden">
				<div class="row marginbottom30">
					<div class="col-xs-6">From: <span class="from" data-teacher-id=""></span></div>
					<div class="col-xs-6 date right"></div>
				</div>
				<hr />
				<div class="title marginbottom20"></div>
				<div class="content marginbottom30"></div>
				<button class="button reply" type="button">Reply</button><a class="back">View All Incoming Messages</a>
			</div>
			<div class="sq-reply-message-container sq-hidden">
				<div class="row marginbottom30">
					<div class="col-xs-6">To: <span class="to" data-teacher-id=""></span></div>
				</div>
				<hr />
				<div class="form-group title">
				</div>
				<div class="form-group">
					<textarea name="message" class="message form-control"></textarea>
				</div>
				<button class="button send" type="button">Send</button><a class="cancel">X Cancel</a>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="outgoing">
			<table id="outgoing-messages" class="table table-striped table-hover" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>To</th>
						<th>Body</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="sq-view-message-container sq-hidden">
				<div class="row marginbottom30">
					<div class="col-xs-6">To: <span class="to" data-teacher-id=""></span></div>
					<div class="col-xs-6 date right"></div>
				</div>
				<hr />
				<div class="title marginbottom20"></div>
				<div class="content marginbottom30"></div>
				<a class="back">View All Outgoing Messages</a>
			</div>
		</div>
	</div>
</div>
