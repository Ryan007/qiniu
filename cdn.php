<?php
/*
   Plugin Name: Simple Qiniu CDN PLUGIN
   Description: mainly use cdn your website.
   */

function qiniu_option_page() {
		if( !empty($_POST) && check_admin_referer('cccomm_admin_options-update') ) {
					update_option('blog_host', $_POST['blog_host']);
							update_option('qiniu_host', $_POST['qiniu_host']);
									update_option('qiniu_dir', $_POST['qiniu_dir']);
											update_option('qiniu_extend', $_POST['qiniu_extend']);
													?>
																<div id="message" class="updated">
																			<p><strong>恭喜您，保存成功！</strong></p>
																					</div>
																							<?php
																								}
			
			?>
					<div class="wrap">
							<?php screen_icon(); ?>
									<h2>七牛cdn简单插件 </h2>
											<p>欢迎使用七牛cdn插件，方便简单。</p>
													<form action="" method="post" id="cc-comments-email-options-form">
																<table class="form-table">
																                <tbody>
																				                    <tr>
																									                        <th scope="row"><label for="host">七牛域名</label></th>
																															                        <td>
																																					                            <input type="url" size="64"  name="qiniu_host" id="qiniu_host"
																																												                                value="<?php echo get_option('qiniu_host'); ?>" /><p>设置为七牛提供的测试域名或者在七牛绑定的域名。<strong>注意要域名前面要加上 http://</strong>。<br />如果博客安装的是在子目录下，比如 http://www.xxx.com/blog，这里也需要带上子目录 /blog </p></td>
																																																				                    </tr>
																																																									                    <tr>
																																																														                        <th scope="row"><label for="bucket">博客域名</label></th>
																																																																				                        <td>
																																																																										                            <input type="text" size="64"  name="blog_host" id="blog_host"
																																																																																	                                value="<?php echo get_option('blog_host'); ?>" />
																																																																																									                        </td>
																																																																																															                    </tr>
																																																																																																				                    <tr>
																																																																																																									                        <th scope="row"><label for="bucket">扩展名</label></th>
																																																																																																															                        <td>
																																																																																																																					                            <input type="text" size="64"  name="qiniu_dir" id="qiniu_dir"
																																																																																																																												                                value="<?php echo get_option('qiniu_dir'); ?>" />
																																																																																																																																				                                <p>一般是“wp-content|wp-includes”</p>
																																																																																																																																												                        </td>
																																																																																																																																																		                    </tr>
																																																																																																																																																							                    <tr>
																																																																																																																																																												                        <th scope="row"><label for="bucket">七牛空间名</label></th>
																																																																																																																																																																		                        <td>
																																																																																																																																																																								                            <input type="text" size="64"  name="qiniu_extend" id="qiniu_extend"
																																																																																																																																																																															                                value="<?php echo get_option('qiniu_extend'); ?>" />
																																																																																																																																																																																							                                <p>一般是“js|css|png|jpg|jpeg|gif|ico”</p>
																																																																																																																																																																																															                        </td>
																																																																																																																																																																																																					                    </tr>
																																																																																																																																																																																																										                </tbody>
																																																																																																																																																																																																														            </table> 

																																																																																																																																																																																																																				<input type="submit" name="submit" value="保存"  class="button-primary" />  
																																																																																																																																																																																																																							<?php wp_nonce_field('cccomm_admin_options-update'); ?>
																																																																																																																																																																																																																									</form>
																																																																																																																																																																																																																										</div>
																																																																																																																																																																																																																											<?php
}

function cdn_plugin_menu() {
		add_options_page('请您配置七牛', '配置七牛CDN', 'manage_options', 'simple-cdn-plugin','qiniu_option_page' );
}

add_action( 'admin_menu', 'cdn_plugin_menu' );
add_filter( 'the_content', 'cdn_filter');

function cdn_filter($html) {
		if ( !is_admin() ) {
			       $local_host = "<?php echo get_option('blog_host'); ?>"; //博客域名
				          $qiniu_host = "<?php echo get_option('qiniu_host'); ?>"; //七牛域名
						         $cdn_exts   = "<?php echo get_option('qiniu_extend'); ?>"; //扩展名（使用|分隔）
								        $cdn_dirs   = "<?php echo get_option('qiniu_dir'); ?>"; //目录（使用|分隔）

										       $cdn_dirs   = str_replace('-', '\-', $cdn_dirs);

											          if ($cdn_dirs) {
														                $regex        =  '/' . str_replace('/', '\/', $local_host) . '\/((' . $cdn_dirs . ')\/[^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
																		              $html =  preg_replace($regex, $qiniu_host . '/$1$4', $html);
																					         } else {
																								               $regex        = '/' . str_replace('/', '\/', $local_host) . '\/([^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
																											                 $html =  preg_replace($regex, $qiniu_host . '/$1$3', $html);
																															        }
													         return $html;
																}
}

?>
