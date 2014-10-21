var SitemasterAjax = Class.create(Ajax);

SitemasterAjax.Request = Class.create(Ajax.Request, {
    initialize: function($super, url, options) {
        this.action_content = options.action_content || [];
        this.custom_content = options.custom_content || [];
        $super(url, options);
    },
    request: function ($super, url)
    {
        var params = !Object.isString(this.options.parameters) ?
            this.options.parameters :
            this.options.parameters.toQueryParams();

        //add sitemaster_ajax flat
        params['sitemaster_ajax'] = 1;

        //add action content params
        var actionContent = this.action_content;
        if (Object.isString(actionContent)) {
            actionContent = [actionContent];
        }
        for (var i = 0; i < actionContent.length; ++i) {
            params['action_content[' + i + ']'] = actionContent[i];
        }

        //add custom content params
        var customContent = this.custom_content;
        if (Object.isString(customContent)) {
            customContent = [customContent];
        }
        for (var i = 0; i < customContent.length; ++i) {
            params['custom_content[' + i + ']'] = customContent[i];
        }

        this.options.parameters = params;

        $super(url);
    }
});
