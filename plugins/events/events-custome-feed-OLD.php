<?php 
	//header('Content-Type: application/json');
	function the_feed(){
	$feed = array();
	/*
	$feed['items'][]= [
		'_acf': {
			
		
		//foreach $acf
		
		}
	]
		
		//struct =
		{
			'id': ''//WP URL as Unique ID
			'context_text': '',//Maybe title can be used
			'url': '' //WP URL as URL,
			'_acfs':{
				"about": ''
				
			},
			'_taxonomies':{
				'var': ''
			}
		}
		*/
		

		/*
		Extension Doc
		1. items are comma separated
		2. _Extensions are preceded by comma, or proceded by comma if there is another element in the "Item" or if it is nested under item 
		only extension ex = https://micro.blog/feeds/manton.json
		Further naming rules: the extension name and its member keys must not contain any . characters. The extension name, and only the extension name, must begin with an _ character. (No standard keys will ever begin with an _ — this is reserved for extensions.)*/
	//define items
	
		//cycle post
			//cycle taxonomies
				//cycle terms
					//test term
						//add term
		
		//get all of the custom taxonomies: I.e. 
		//loop query
		$args =	array('post_type'=>'mec-events','posts_per_page'=>9999);
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
				
				$locationId = get_post_meta($id, 'mec_location_id', true);
				/* based on location id, get location taxonomy name */
				//$location = get_term_by('id', $locationId, 'mec_location');
				
				$location = the_terms( $id, 'mec_category', 'Topics: ', ', ', ' ' );

				
				
				//$locationOld = isset($id->data->locations[$id->data->meta['mec_location_id']]) ? $id->data->locations[$id->data->meta['mec_location_id']]['address'] : '';
				
				
				$start = get_post_meta($id, 'mec_start_date', true);
				$end = get_post_meta($id, 'mec_end_date', true);
				$info = get_the_content();
				
				
				
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
//										 echo "Hit";
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
			'title' =>  $title,
			'start' => $start,
			'end' => $end,
			'cat' => $eventCat,
			'location' => $location,
			'locationId' => $locationId,
			'feat_image' => $image,
			'url' => $perma,
			'_acf' => $acf_writer,
			'_taxonomies' => $tax_extension
			];

		}	
		}else{ echo "nothing";} //no posts found //end the loop //
		//echo "<br><br><br>";
		//echo json_encode($feed);
		/*$feed[] = [
			"title" => "Winter Intersession - 6 Weeks",
            "start" => "2018-01-03 08:00:00",
            "url" => "http://25livepub.collegenet.com/calendars/academic-calendar-updated?eventid=229935713",
            "guid" => "http://uid.trumba.com/event/229935713",
            "author" => "",
            "thumbnail" => "",
            "description" => "Ongoing through Tuesday, February 13, 2018, 11:59pm <br><br><p><a href=\"http://pasadena.edu/calendars/academic.php\" target=\"_blank\">Click here to view Academic Calendars</a></p> \n",
            "content" => "Ongoing through Tuesday, February 13, 2018, 11:59pm <br><br><p><a href=\"http://pasadena.edu/calendars/academic.php\" target=\"_blank\">Click here to view Academic Calendars</a></p> \n",
            "enclosure" => [],
            "categories" => [
                "2018/01/03 (Wed)"
            ]
		];*/
		
		$data = json_encode($feed);
//		if(file_exists('/home/mackeycl/webapps/pccevents_wp/events-test/_events_resources/events_sample.json')){
//			echo "File exists";
		/*  WRITE TO JSON FILE
		$dir = '/home/mackeycl/webapps/pccevents_wp/events-test/_events_resources';
		//echo $dir;
		if ( !file_exists($dir) ) {
			 $oldmask = umask(0);  // helpful when used in linux server  
			 mkdir ($dir, 0777);
		 }
		 */
		$dir = '/home/mackeycl/webapps/fhg_wp/events_feed';

		 file_put_contents ($dir.'/event_feed.json', $data);
	}
add_action('init', 'the_feed');
?>