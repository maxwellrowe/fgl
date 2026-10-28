<?php 
	//header('Content-Type: application/json');
	function the_feed_board(){
	$feed = array();
		//loop query
		$args =	array(
			'post_type'=>'fglevent',
			'post_status'=>'publish',
			'posts_per_page'=>9999,
			'tax_query' => array(
				array(
					'taxonomy' => 'eventcat',
					'field' => 'slug',
					'terms' => 'board-meeting'
				),
			),
		);
		$query = new WP_Query($args);
		//theLoop
		if($query->have_posts()){
			//cycle post
          //cycle through the entire custom field of a custom post type:
          #get_post_meta( get_the_ID(), '_location', true );
          //OR
          #get_post_custom()
			while($query->have_posts()){
				$query->the_post();
				$title = get_the_title();
				$id = get_the_ID();
				$image = get_the_post_thumbnail_url();
				$perma = get_the_permalink();
				$start = get_field('start_date_and_time');
				$end = get_field('end_date_and_time');
				$info = get_the_content();
				
				/* Attached Files */
				// $rows = get_field('repeater' ); // get all the rows
				// $specific_row = $rows[YOUR_ROW_NUMBER]; // 0 will get the first row, remember that the count starts at 0
				// $sub_field_value = $specific_row['SUB_FIELD_NAME']; // get the sub field value
				
				/* Get the custom taxonomy terms */
				$term_obj_list_category = get_the_terms( $post->ID, 'eventcat' );
				$eventCat = join(', ', wp_list_pluck($term_obj_list_category, 'name'));
				
				$term_obj_list_category_slug = get_the_terms( $post->ID, 'eventcat' );
				$eventCatSlug = join(', ', wp_list_pluck($term_obj_list_category_slug, 'slug'));
				
				/* Get Event Location Taxonomy */
				$eventLocation = get_the_term_list( $post->ID, 'eventlocation', '', ', ' );
				$eventLocation = strip_tags( $eventLocation );
				
				/* Get the Cancelled ACF Field */
				$eventCancelled = get_field('cancelled');
				
				/* Get the Attached Files */
				$attachmentOneFile = get_field('attached_file_one');
				$attachmentOneName = get_field('attachment_one_name');
				
				$attachmentTwoFile = get_field('attachment_two_file');
				$attachmentTwoName = get_field('attachment_two_name');
				
				$attachmentThreeFile = get_field('attachment_three_file');
				$attachmentThreeName = get_field('attachment_three_name');
				
				$attachmentFourFile = get_field('attachment_four_file');
				$attachmentFourName = get_field('attachment_four_name');

				$acf_writer = array();
				$tax_extension = array();
				//get all of the ACFS
				/*$acfs = get_fields($query->the_post());
				foreach($acfs as $acf => $value){
					
					echo "ACF: ".$acf." = " . $value."<br>";
				}*/
				//objects Methods
				$acfs = get_field_objects();
				if($acfs){
					foreach($acfs as $acf => $val){	
						$acf_writer[$acf] = $val['value'];
						//echo "'".$acf."' => '".$val['value']."'<br>";
					}
				};
				//get taxonomies
					$args = array(
					  'public'   => true,
					  '_builtin' => false
						); 
						$taxonomies = get_taxonomies( $args);
						if($taxonomies){
						//cycle taxonomies -> VAL as $tax, not $tax->name;
						foreach ($taxonomies as $tax){
							//get Terms of taxonomy (ROSEMEAD ETC)
							$terms = get_terms($tax);
								//cycle terms
								foreach($terms as $term){
									//test specifc term term
									 if(has_term($term->name, $tax)){
									 // echo "Hit";
										$tax_extension[] = [
											$tax => $term->name	
										];
									 }
									
									
							}
					}//end $taxonomies	
			}
			//inject new $feed item post here :)

			$feed[] = [
			'id' => $id,
			'idEvent' => $id,
			'title' =>  $title,
			'eventCat' => $eventCat,
			'eventCatSlug' => $eventCatSlug,
			'location' => $eventLocation,
			'content' =>  $info,
			'eventcancelled' => $eventCancelled,
			'start' => $start,
			'end' => $end,
			'feat_image' => $image,
			//'url' => $perma,
			'attachmentonefile' => $attachmentOneFile,
			'attachmentonename' => $attachmentOneName,
			'attachmenttwofile' => $attachmentTwoFile,
			'attachmenttwoname' => $attachmentTwoName,
			'attachmentthreefile' => $attachmentThreeFile,
			'attachmentthreename' => $attachmentThreeName,
			'attachmentfourfile' => $attachmentFourFile,
			'attachmentfourname' => $attachmentFourName,
			'_acf' => $acf_writer,
			'_taxonomies' => $tax_extension
			];

		}	
		}else{} //no posts found //end the loop //
		
		
		$data = json_encode($feed);

		$dir = '/home/zp46tqwkbf8q/public_html/events_feed';

		 file_put_contents ($dir.'/event_feed_board.json', $data);
	}
