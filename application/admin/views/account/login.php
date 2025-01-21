
		<div class="modal-overs">
			<div class="modal-dialog animated fadeInUp" style="max-width: 400px;min-width: 300px;margin: 30px auto 20px;">
				<div class="box-content modal-content">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12 padding-top-10">
								<h4>Login</h4>
								<form id="loginForm" action="<?php echo site_url('account/login') ?>" autocomplete="off" >
									<div id="error_message_box" class="hide alert alert-danger" role="alert"></div>
									<div class="form-group">
										<label>Email Address</label>
										<input type="text" name="username" id="username" class="form-control" placeholder="Email Address">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" id="password" class="form-control" placeholder="Password">
									</div>
									<div class="checkbox m-t-lg">
										<button type="submit" class="btn btn-sm btn-success pull-right text-uc m-t-n-xs">
										<i class="fa fa-sign-in"></i> <strong>Log in</strong>
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>