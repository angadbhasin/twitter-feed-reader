var Tweet = Backbone.View.extend({
		
    render:function () {
    	var that=this;
    	
    	$.get('app/templates/TweetTemplate.html', function (data) {
    		template = _.template(data, {  });
            that.$el.html(template(that.model.toJSON())); 
            
        }, 'html');
    	
    	return this;
    }
});