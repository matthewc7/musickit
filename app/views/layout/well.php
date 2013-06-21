<? $data = $this->well->regular(); ?>

<div id="regular" class="row">
	<div class="six columns">
		<h6>TOP SONGS</h6>
		<table class="table">
			<? 
				$count = 1;
				foreach ($data['songs'] as $song): 
					$album_url = $this->itunes->encode($song->link);
			?>
			<tr class="row">
				<td class="">
					<p class="rank"><?= $count++; ?></p>
				</td>
				<td class="image">
					<p>
						<a href="<?= $album_url; ?>" target="itunes_store">
							<img src="<?= $song->thumbnail;?>" class="thumbnail">
						</a>
					</p>
				</td>
				<td class="">
					<p class="title">
						<a href="<?= $album_url; ?>" target="itunes_store">
							<?= format_title($song->name); ?>
						</a>
					</p>
					<p class="artist"><?= format_title($song->artist); ?></p>
					<? if($song->number > 1): ?>
						<p class="label round">No 1 in <?= $song->number; ?> Stores.</p>
					<? else: ?>
						<p class="label round">No 1 in <?= $song->country; ?>.</p>
					<? endif; ?>
				</td>
			</tr>
			<? endforeach; ?>
		</table>
	</div>

	<div class="six columns">
		<h6>TOP ALBUMS</h6>
		<table class="table">
			<? 
				$count = 1;
				foreach ($data['albums'] as $album): 
					$track_url = $this->itunes->encode($album->link);
			?>
			<tr>
				<td>
					<p class="rank"><?= $count++; ?></p>
				</td>
				<td class="image">
					<a href="<?= $track_url; ?>" target="itunes_store">
						<img src="<?= $album->thumbnail;?>" class="thumbnail">	
					</a>
				</td>
				<td>
					<p class="title">
						<a href="<?= $track_url; ?>" target="itunes_store">
							<?= format_title($album->name); ?>
						</a>
					</p>
					<p class="artist"><?= format_title($album->artist); ?></p>
					<? if($album->number > 1): ?>
						<p class="label round">No 1 in <?= $album->number; ?> Stores.</p>
					<? else: ?>
						<p class="label round">No 1 in <?= $album->country; ?>.</p>
					<? endif; ?>
				</td>
			</tr>
			<? endforeach; ?>
		</table>
	</div>




</div>
