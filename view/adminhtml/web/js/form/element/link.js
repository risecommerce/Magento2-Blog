/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

define([
    'Magento_Ui/js/form/element/abstract'
], function (AbstractElement) {
    'use strict';

    return AbstractElement.extend({
        defaults: {
            elementTmpl: 'Risecommerce_Blog/form/element/link'
        },

        initialize: function () {
            this._super();

            var value = this.value();
            this.url = value.url;
            this.title = value.title;
            this.text = value.text;
        },

    });
});