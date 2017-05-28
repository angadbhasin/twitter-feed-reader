var Tweet = Backbone.View.extend({

    tagName:"div",
    className:"tweet-container",
    template:$("#tweetTemplate").html(),

    render:function () {
        var template = _.template(this.template);

        this.$el.html(template(this.model.toJSON()));
        return this;
    }
});