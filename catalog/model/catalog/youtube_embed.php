<?php
class ModelCatalogYoutubeEmbed extends Model {
	public function getYoutubeVideos($string) {
		if ($type == 0) {
			$embed_width = html_entity_decode($this->config->get('youtube_embed_width'));
			$embed_height = html_entity_decode($this->config->get('youtube_embed_height'));
		}
		
		if ($type == 1) {
			$embed_width = html_entity_decode($this->config->get('youtube_embed_category_width'));
			$embed_height = html_entity_decode($this->config->get('youtube_embed_category_height'));
		}
		
		if ($type == 2) {
			$embed_width = html_entity_decode($this->config->get('youtube_embed_information_width'));
			$embed_height = html_entity_decode($this->config->get('youtube_embed_information_height'));
		}
		
		if ($embed_fs == 1) { $embed_fs = 'true'; } else { $embed_fs = 'false'; }
}
?>