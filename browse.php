<?php
if (!defined('WC_BASE')) define('WC_BASE', dirname(__FILE__));
$ref=WC_BASE."/index.php";
if ($ref!=$_SERVER['SCRIPT_FILENAME']){
	header("Location: index.php");
	exit();
}
?>
<!-- ############################## Start browse.php ###################################### -->
<tr>
	<td width="10">&nbsp;</td>

	<td valign="top">
		<h3>
			<?php print _("Browse domains");?>
		</h3>

		<table border="0">
			<tbody>
				<tr>
					<th colspan="4">
						<?php print _("action");?>
					</th>

					<th>
						<?php print _("domainname");?>
					</th>

					<?php
					if (! $DOMAIN_AS_PREFIX){
						?>
						<th>
							<?php print _("prefix");?>
						</th>
						<?php
					}
					?>

					<th>
						<?php print _("max Accounts");?>
					</th>
					
					<th>
						<?php print _("max Domain quota");?>
					</th>

					<th>
						<?php print _("default quota per user");?>
					</th>
				</tr>
				
				<?php

				if (! isset($allowed_domains)) {
					$query = "SELECT * FROM domain ORDER BY domain_name";
				} else {
//					$query = "SELECT * FROM domain WHERE domain_name='$allowed_domains' ORDER BY domain_name";
					$query = "SELECT * FROM domain WHERE domain_name='";
					for ($i = 0; $i < $cnt; $i++){
						$row=$result->fetchRow(DB_FETCHMODE_ASSOC, $i);
						$allowed_domains=$row['domain_name'];
//						print "DEBUG: Allowed Domains".$allowed_domains;
						$query.="$allowed_domains' OR domain_name='";
					}
					$query .= "' ORDER BY domain_name";
//					print $query;
				}

				$result = $handle->query($query);
				$cnt    = $result->numRows($result);

				for ($c=0; $c < $cnt; $c++){
					if ($c%2==0){
						$cssrow="row1";
					} else {
						$cssrow="row2";
					}

					$row = $result->fetchRow(DB_FETCHMODE_ASSOC,$c);

					?>
					<tr class="<?php echo $cssrow;?>">
						<?php
						$_cols = array(
							'editdomain'	=> _("Edit Domain"),
							'deletedomain'	=> _("Delete Domain"),
							'accounts'	=> _("accounts"),
							'aliases'	=> _("Aliases")
						);
						foreach ($_cols as $_action => $_txt){
							?>
							<td>
								<?php
								printf ('<a href="index.php?action=%s&amp;domain=%s">%s</a>',
									$_action, $row['domain_name'], $_txt);
								?>
							</td>
							<?php
						}
						?>

						<td>
							<?php echo $row['domain_name'];?>
						</td>

						<td>
							<?php
							if (! $DOMAIN_AS_PREFIX){
								# Print the prefix
								echo $row['prefix'];
								echo "</td><td>";
							}
							?>
							<!-- Max Account -->
							<?php
							echo $row['maxaccounts'];
							?>
						</td>
						
						<td>
							<!--  Max Domain Quota -->
							<?php
							if (! $row['domainquota'] == 0) {
								echo $row['domainquota'];
							} else {
								print _("Quota not set");
							}
							?>
						</td>
						
						<td>
							<!-- Default Account Quota -->
							<?php
							echo $row['quota'];
							?>
						</td>
					</tr>
					<?php
				} // End of for
				?>
			</tbody>
		</table>
<!-- ############################### End browse.php ############################################# -->

