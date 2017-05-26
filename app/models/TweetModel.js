var Tweet = Backbone.Model.extend({
	// set up defaults for the tweet model
	defaults:{
	    name:"",
	    screen_name:"",
	    profile_image_url:"",
	    text:"",
	    retweet_count:""
	}
});