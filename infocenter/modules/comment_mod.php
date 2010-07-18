<?php
	require_once("base_mod.php");
	require_once("level_mod.php");
	require_once("comment.php");

	class CommentMod extends BaseMod {
		public static function addComment($com) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"insert into ".SettingsMod::DB_TABLE_PREFIX."comment(" .
						"universe, `table`, table_id, name, `when`, data" .
					")" .
					" values ('%s', '%s', %d, '%s', '%s', '%s');",
					mysql_real_escape_string($com->getUniverse()),
					mysql_real_escape_string($com->getTable()),
					intval($com->getTableId()),
					mysql_real_escape_string($com->getName()),
					date("Y-m-d H-i-s", $com->getWhen() / 1000),
					mysql_real_escape_string($com->getData())
				);
			return mysql_query($sql, $conn);
		}

		public static function getComments($table, $id) {
			$conn = self::getConnection();

			$where = sprintf(
				"where `table` = '%s' and table_id = %d ",
				mysql_real_escape_string($table), intval($id)
			);

			$sql =
				"select * from comment " .
				$where .
				"order by `when` asc";
			$comments = array();
			$result = mysql_query($sql, $conn);
			while ($row = mysql_fetch_assoc($result)) {
				$com =
					new Comment(
						$row["id"],
						$row["universe"],
						$row["table"],
						$row["table_id"],
						$row["name"],
						$row["when"],
						$row["data"]
					);
				$comments[$com->getId()] = $com;
			}
			return $comments;
		}

		public static function getCommentCount($table, $id) {
			$conn = self::getConnection();

			$where = sprintf(
				"where `table` = '%s' and table_id = %d ",
				mysql_real_escape_string($table), intval($id)
			);

			$sql =
				"select count(*) as cnt from comment " .
				$where .
				"order by `when` asc";
			$comments = array();
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);
			return $row["cnt"];
		}

		public static function getComment($id) {
			$conn = self::getConnection();

			$where = sprintf(
				"where id = %d ",
				intval($id)
			);

			$sql =
				"select * from comment " .
				$where .
				"order by `when` asc";
			$comments = array();
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);
			$com =
				new Comment(
					$row["id"],
					$row["universe"],
					$row["table"],
					$row["table_id"],
					$row["name"],
					$row["when"],
					$row["data"]
				);

			return $com;
		}

		public static function updateComment($com) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update comment set data = '%s' where id = %d",
				mysql_real_escape_string($com->getData()),
				intval($com->getId())
			);

			mysql_query($sql, $conn);
		}

		public static function deleteComment($com) {
			$conn = self::getConnection();
			$sql = sprintf(
				"delete from comment where id = %d",
				intval($com->getId())
			);

			mysql_query($sql, $conn);
		}

		public static function drawComment(
			$com, $draw_options = true, $editable = false
		){
			?>
			<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" width="500">
				<tr>
					<td style="text-align: left">Author:&nbsp;<?php echo($com->getName()); ?></td>
					<td style="text-align: right"><script language="javascript">document.write(formatDate(<?php echo(strtotime($com->getWhen()) * 1000)?>))</script>
				</tr>
				<?php if ($editable): ?>
				<tr>
					<td colspan="2"><textarea name="data" class="comment"><?php echo($com->getData()); ?></textarea><br /><br /></td>
				</tr>
				<?php else: ?>
				<tr>
					<td colspan="2"><?php echo($com->getData()); ?><br /><br /></td>
				</tr>
				<?php endif;

				if (
					$draw_options && (
						$_SESSION["account"]->getName() == $com->getName() ||
						$_SESSION["account"]->getLevel() == 'Admin'
					)
				): ?>
				<tr>
					<td colspan="2" style="text-align: right">
						<a href="comment_edit.php?id=<?php echo($com->getId()); ?>">Edit&nbsp;Comment</a>&nbsp;<b>&middot;</b>&nbsp;<a href="comment_delete.php?id=<?php echo($com->getId()); ?>">Delete&nbsp;Comment</a>
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<br />
			<?php
		}

		public static function drawComments($table, $id, $permissions) {
			$comments = CommentMod::getComments($table, $id);
			$num_comments = count($comments); ?>
			<a href="#" onclick="comments_toggle();">[<span id="expander">+</span>]&nbsp;<?php echo($num_comments); ?>&nbsp;Comment(s)&nbsp;(click&nbsp;to&nbsp;expand/contract)</a>
			<div id="comments">
			<br /><br />
			<?php foreach($comments as $com) {
				CommentMod::drawComment($com, $editable = $permissions->has(Permissions::MODIFY_COMMENTS));
			}

			if ($permissions->has(Permissions::MODIFY_COMMENTS)): ?>
			<form method="post" action="comment_add.php?table=<?php echo($table); ?>&amp;id=<?php echo($id); ?>">
			<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" width="500">
				<tr>
					<td style="padding: 5px 0px; text-align: center">
						<textarea name="data" class="comment"></textarea>
						<br /><br />
						<input type="submit" value="Submit Comment" />
					</td>
				</tr>
			</table>
			</form>
			<?php endif; ?>
			</div>
			<?php
		}
	}
?>
