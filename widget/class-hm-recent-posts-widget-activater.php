<?php
error_reporting(0);
/**
* Adds HM Recent Posts widget in Widget area
*/
class HmRecentPostsWidgetActivater extends WP_Widget {
	
	/**
	* Register widget with WordPress.
	*/
	function __construct() {
		parent::__construct(
			'hmrecentpostswidgetactivater', // Base ID
			__('HM Recent Posts', 'text_domain'), // Widget name which will display in the widget area
			array( 'description' => __( 'Display Your Recent Post', 'text_domain' ), ) // Args
		);
	}
	
	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args Widget arguments.
	* @param array $instance Saved values from database.
	*/
	public function widget( $args, $instance )
	{	
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) )
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		if ( ! empty( $instance['numberOfPosts'] ) ) {
			$showPosts = $instance[ 'numberOfPosts' ];
		}
		if ( ! empty( $instance['numberOfPosts'] ) ) {
			$displayCategory = $instance[ 'displayCategory' ];
		}
		/*if ( ! empty( $instance['openPostLinkTab'] ) ) {
			echo $openPostLinkTab = $instance[ 'openPostLinkTab' ];
		}*/
		$openPostLinkTab = $instance[ 'openPostLinkTab' ] ? 'true' : 'false';
		$hidePostTitle = $instance[ 'hidePostTitle' ] ? 'true' : 'false';
		$postThumbnail = $instance[ 'postThumbnail' ] ? 'true' : 'false';
		$thumbnailBorder = (isset($instance[ 'thumbnailBorder' ])) ? 'true' : 'false';
		$thumbnailHeight = (isset($instance[ 'thumbnailHeight' ])) ? $instance[ 'thumbnailHeight' ] : 50;
		$thumbnailWidth = (isset($instance[ 'thumbnailWidth' ])) ? $instance[ 'thumbnailWidth' ] : 50;
		
		$target = ($openPostLinkTab == 'true') ? '_blank' : '_parent';
		$thumbnail_border = ($thumbnailBorder == 'true') ? '3px solid #CCC' : '0px';
		
		$theQuery = '';
		$queryArgs = array(	'cat' => $displayCategory, //category_name
							'showposts' => $showPosts, 
							'order' => 'DESC' );
		$theQuery = new WP_Query( $queryArgs );
		
		// This is to display the query
		//echo "Last SQL-Query: {$queryNonStickyKhelaAll1->request}";
		
		while ($theQuery -> have_posts()) : $theQuery -> the_post(); ?>
		
		<style>
		.hmrpw-thumbnail-container img {
			border: <?php echo $thumbnail_border; ?>;
			width: <?php echo $thumbnailWidth; ?>px;
			height: <?php echo $thumbnailHeight; ?>px;
		}
		</style>
		
		<div class="" style="border-bottom:1px solid #EAEAEA; background:#FFF; padding:4px 0px;">
			<div class="hmrpw-thumbnail-container" style="border:0px solid #EAEAEA; width:30%; float:left; text-align:center;">
				<?php if($postThumbnail=='true') the_post_thumbnail( 'thumbnail' ); ?>
			</div>
			<div class="" style="border:0px solid #DDD; width:70%; padding:0 2%; float:left; min-height:40px;">
				<p style="margin:0; padding:0; padding-bottom:8px; font-size:14px;">
					<?php if($hidePostTitle == 'false') { ?>
						<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark" target=<?php echo $target; ?>><?php the_title(); ?></a>
					<?php } ?>
				</p>
				<P style="font-size:11px; color:#666; border:0px solid #000; margin:0px; padding:0px;">
					<?php echo the_time('M d, Y'); ?> | <?php the_category(', ') ?>
				</P>
			</div>
			<div style="clear:both"></div>
		</div>
		<?php endwhile; ?>
		<br /><br />
		<?php
		echo $args['after_widget'];
	}
	
	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) 
	{
		//print_r($instance);
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Recent Posts', 'numberOfPosts' => 5, 'displayCategory' => '', 'openPostLinkTab' => 'true', 'hidePostTitle' => 'true', 'postThumbnail' => 'true', 'thumbnailBorder' => 'false' ) );
		//print_r($instance);
        $title = $instance['title'];
		$numberOfPosts = $instance[ 'numberOfPosts' ];
		$displayCategory = $instance[ 'displayCategory' ];
		$openPostLinkTab = $instance[ 'openPostLinkTab' ];
		$hidePostTitle = $instance[ 'hidePostTitle' ];
		$postThumbnail = $instance[ 'postThumbnail' ];
		$thumbnailBorder = $instance[ 'thumbnailBorder' ];
		$thumbnailHeight = (isset($instance[ 'thumbnailHeight' ])) ? $instance[ 'thumbnailHeight' ] : 50 ;
		$thumbnailWidth = (isset($instance[ 'thumbnailWidth' ])) ? $instance[ 'thumbnailWidth' ] : 51 ;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'numberOfPosts' ); ?>">Number of Posts to show:</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'numberOfPosts' ); ?>" name="<?php echo $this->get_field_name( 'numberOfPosts' ); ?>" type="number" value="<?php echo esc_attr( $numberOfPosts ); ?>" step="1" min="1" size="4">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'displayCategory' ); ?>">Post Category:</label>
			<select class="tiny-text" id="<?php echo $this->get_field_id( 'displayCategory' ); ?>" name="<?php echo $this->get_field_name( 'displayCategory' ); ?>">
				<option value="">All Category</option>
				<?php 
				$hmrpw_args = array(  	'type'                     => 'post',
										'child_of'                 => 0,
										'parent'                   => '',
										'orderby'                  => 'name',
										'order'                    => 'ASC',
										'hide_empty'               => 1,
										'hierarchical'             => 1,
										'exclude'                  => '',
										'include'                  => '',
										'number'                   => '',
										'taxonomy'                 => 'category',
										'pad_counts'               => false 	
									); 
				$hmrpw_categories = get_categories( $hmrpw_args ); 
				foreach( $hmrpw_categories as $cat ) :
				?>
            	<option <?php if( $cat->cat_ID == $instance['displayCategory'] ) echo 'selected'; ?> value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->name; ?></option>
				<?php endforeach; ?>
            </select>
		</p>
		<!-- Thumbnail Settings -->
		<hr />
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'postThumbnail' ); ?>" name="<?php echo $this->get_field_name( 'postThumbnail' ); ?>" <?php checked( $instance[ 'postThumbnail' ], 'on' ); ?> /> 
    		<label for="<?php echo $this->get_field_id( 'postThumbnail' ); ?>">Display Post Thumbnail</label><br>
			
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'thumbnailBorder' ); ?>" name="<?php echo $this->get_field_name( 'thumbnailBorder' ); ?>" <?php checked( $instance[ 'thumbnailBorder' ], 'on' ); ?> /> 
    		<label for="<?php echo $this->get_field_id( 'thumbnailBorder' ); ?>">Show Thumbnail Border</label><br>
			
    		<label for="<?php echo $this->get_field_id( 'thumbnailHeight' ); ?>">Thumbnail Height:</label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'thumbnailHeight' ); ?>" name="<?php echo $this->get_field_name( 'thumbnailHeight' ); ?>" type="number" value="<?php echo esc_attr( $thumbnailHeight ); ?>" step="1" min="50"><br>
			
			<label for="<?php echo $this->get_field_id( 'thumbnailWidth' ); ?>">Thumbnail Width:</label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'thumbnailWidth' ); ?>" name="<?php echo $this->get_field_name( 'thumbnailWidth' ); ?>" type="number" value="<?php echo esc_attr( $thumbnailWidth ); ?>" step="1" min="50"><br>
		</p>
		<!-- End of Thumbnail Settings -->
		<!-- Post Tile Settings -->
		<hr />
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'hidePostTitle' ); ?>" name="<?php echo $this->get_field_name( 'hidePostTitle' ); ?>" <?php checked( $instance[ 'hidePostTitle' ], 'on' ); ?> /> 
    		<label for="<?php echo $this->get_field_id( 'hidePostTitle' ); ?>">Hide post title</label>
		</p>
		<!-- End of Post Tile Settings -->
		<!-- -->
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'openPostLinkTab' ); ?>" name="<?php echo $this->get_field_name( 'openPostLinkTab' ); ?>" <?php checked( $instance[ 'openPostLinkTab' ], 'on' ); ?> /> 
    		<label for="<?php echo $this->get_field_id( 'openPostLinkTab' ); ?>">Open post links in new tab</label>
		</p>
		<?php
	}
	
	/*
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['numberOfPosts'] = $new_instance['numberOfPosts'];
		$instance['displayCategory'] = $new_instance['displayCategory'];
		$instance['openPostLinkTab'] = $new_instance['openPostLinkTab'];
		$instance['hidePostTitle'] = $new_instance['hidePostTitle'];
		$instance['postThumbnail'] = $new_instance['postThumbnail'];
		$instance['thumbnailBorder'] = $new_instance['thumbnailBorder'];
		$instance['thumbnailHeight'] = $new_instance['thumbnailHeight'];
		$instance['thumbnailWidth'] = $new_instance['thumbnailWidth'];
		return $instance;
	}
}
?>