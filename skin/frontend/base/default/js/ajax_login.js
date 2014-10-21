AjaxLogin = Class.create();
AjaxLogin.prototype = new VarienForm();

AjaxLogin.prototype.initialize = (function(superConstructor) {
    return function(formId, firstFieldFocus) {
        superConstructor.call(this, formId, firstFieldFocus);
        // if we have form element
        if (this.form) {
            this.responseBlock = null;
            this.loadingBlock  = $(this.form.id + '-ajax');
            this.form.observe('submit', this.submit.bindAsEventListener(this))
        }
    };
})(VarienForm.prototype.initialize);

AjaxLogin.prototype.submit = function(e) {
    if(this.validator && this.validator.validate()) {
        this._submit(this.form.getAttribute('action'));
    }
    Event.stop(e);
    return false;
};

AjaxLogin.prototype._submit = function(url) {
    if (this.loadingBlock) {
        this.loadingBlock.show();
    }
    new Ajax.Request(url, {
        method: this.form.getAttribute('method') || 'get',
        parameters: this.form.serialize(),
        onComplete: this._processResult.bind(this),
        onFailure: function() {
            location.href = BASE_URL;
        }
    });
};

AjaxLogin.prototype.setResponseMessage = function(type, msg) {
    if (!this.responseBlock) {
        Element.insert(this.form, { before: '<div></div>' });
        this.responseBlock = this.form.previous('div');
    }
    this.responseBlock.update(msg.join ? msg.join("<br />") : msg);
    this.responseBlock.className = type;
    return this;
};

AjaxLogin.prototype._processResult = function(transport){
    if (this.loadingBlock) {
        this.loadingBlock.hide();
    }

    var response = '';
    try {
        response = transport.responseText.evalJSON();
    } catch (e) {
        response = transport.responseText;
    }

    if (response.error) {
        this.setResponseMessage('error', response.error);
    } else if(response.success) {
        this.setResponseMessage('success', response.success);
        if (response.formVisibility == 'hide') {
            this.form.hide();
        }
    } else {
        var url = response.redirect ? response.redirect : location.href;
        location.href = url;
    }
};

$(document).observe('dom:loaded', function() {
    var loginBtn = $$('div.header div.quick-access ul.links a[href$="/login/"]')[0];
    if (loginBtn) {
        loginBtn.observe('click', function(e) {
            var popup = $('login-popup');
            if (popup.offsetWidth) {
                popup.hide()
            } else {
                popup.show();
            }
            Event.stop(e);
        });
        $('popup-close').observe('click', function(e) {
            $(this.parentNode).hide();
            Event.stop(e);
        });
    }
})
