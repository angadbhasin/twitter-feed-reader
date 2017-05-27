var Tweets = Backbone.Collection.extend({
  model:Tweet,
  url: 'api/tweets/salesforce/10',
  parse: function (response) {
	   var tweetList= [];
	   var data		= JSON.parse(response);

	   $.each( data, function( idx, value ) {
		   var tweet= {};
		   var tweetDate = new Date(value.created_at);

		   //build the model with values we need for displaying data
		   tweet['profilePicture']	= value.user.profile_image_url;
		   tweet['media']			= value.entities.media;
		   tweet['name']			= value.user.name;
		   tweet['screenName']		= value.user.screen_name;
		   tweet['comment']			= value.text;
		   tweet['retweetCount']	= value.retweet_count;
		   tweet['date']			= new Date(value.created_at).toUTCString();
	   
	   tweetList.push(tweet);
   });
   return tweetList;
  }
});