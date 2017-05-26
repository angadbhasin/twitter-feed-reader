var SearchView = Backbone.View.extend({
	el: $(".search-area"),
    
    events: {
      "keyup input[name='search-tweet']": "check"
    },

    check: function() {
    	 var searchTerm = this.$('.search-box').val().toLowerCase();
    	 $('.tweet-container').each(function() {
    		 
    		 var content= $(this).find('.comment').text();
    		 var found	= content.search(new RegExp(searchTerm, "i")) == -1;

    		 $(this).toggle(!found);
    	 });
    }
});