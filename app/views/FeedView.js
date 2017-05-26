var TweetView = Backbone.View.extend({
    el:$("#tweets"),

    initialize:function() {
    	
    	var that = this;
    	
        this.collection = new Tweets();
        this.collection.fetch({
        	success:function (collection, response, options) {
        		that.render();
        	},
        	error:function(collection, response, options) {
                alert("An error occured while retrieveing your feed");
            }
        });
        
        // Update the feed every
        setInterval(function() {
        	that.updateFeed();
        }, 5000000000);
    },

    updateFeed:function() {
        this.$el.find(".tweet-container").remove();
        this.render();
    },
    
    render: function() {
        var that = this;
        _.each(this.collection.models, function(item) {
            that.renderTweet(item);
        }, this);
    },

    renderTweet:function(item) {
        var tweetView = new Tweet({
            model: item
        });
        this.$el.append(tweetView.render().el);
    }
});