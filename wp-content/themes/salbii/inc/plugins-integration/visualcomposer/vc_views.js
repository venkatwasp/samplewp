(function ($) {

    if(window.VcRowViewCustomized === undefined) {
        window.VcRowViewCustomized = window.VcRowView.extend({
            cloneModel:function (model, parent_id, save_order) {

                var new_params = _.extend({}, model.get('params'));

                if (model.get('shortcode') === 'vc_tab') {
                    new_params = _.extend(new_params, {tab_id:+new Date() + '-' + Math.floor(Math.random() * 11)});
                }

                var shortcodes_to_resort = [],
                    new_order = _.isBoolean(save_order) && save_order === true ? model.get('order') : parseFloat(model.get('order')) + vc.clone_index,
                    model_clone = vc.shortcodes.create({shortcode:model.get('shortcode'), id:vc_guid(), parent_id:parent_id, order:new_order, cloned:(model.get('shortcode') === 'vc_tab' ? false : true), cloned_from:model.toJSON(), params:new_params});

                _.each(vc.shortcodes.where({parent_id:model.id}), function (shortcode) {
                    this.cloneModel(shortcode, model_clone.get('id'), true);
                }, this);
                return model_clone;
            }
        });
    }

    if(window.VcProjectsGridView === undefined){
        window.VcProjectsGridView = vc.shortcode_view.extend({
            initialize:function (options) {
                window.VcProjectsGridView.__super__.initialize.call(this, options);
            },
            ready:function (e) {
                window.VcProjectsGridView.__super__.ready.call(this, e);
                return this;
            },
            render:function () {
                window.VcProjectsGridView.__super__.render.call(this);
                return this;
            }
        });
    }

    if(window.VcIconboxView === undefined){
		window.VcIconboxView = VcColumnView.extend({
			events:{
			  'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			  'click > .vc_controls .vc_control-btn-prepend':'addElement',
			  'click > .vc_controls .vc_control-btn-edit':'editElement',
			  'click > .vc_controls .vc_control-btn-clone':'clone',
			  'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
			},
            initialize:function (options) {
                window.VcIconboxView.__super__.initialize.call(this, options);
                _.bindAll(this, 'setDropable', 'dropButton');
            },
            ready:function (e) {
                window.VcIconboxView.__super__.ready.call(this, e);
                this.setDropable();
                return this;
            },
            render:function () {
                window.VcIconboxView.__super__.render.call(this);
                this.$el.attr('data-width', this.model.get('params').width);
                this.$el.addClass("wpb_content_element");
                this.setEmpty();
                return this;
            }
        });
    }

    if(window.VcPriceBlockView === undefined){

        window.VcPriceBlockView = vc.shortcode_view.extend({

            css_classes: {
                price_block : 'pricingtable-priceblock',
                featured_column : 'pricingtable-featured',
                featured_badge : 'priceblock-badge',
                title : 'title',
                price : 'price',
                currency : 'currency',
                period : 'payment-period',
                description : 'priceblock-description'
            },

            initialize:function (params) {
                window.VcPriceBlockView.__super__.initialize.call(this, params);
            },

            changeShortcodeParams:function (model) {
                var oldParams = this.model.get('params');
                var params = model.get('params');

                var featured_badge = '';
                var is_featured = params['make_featured'] == 'true';

                if (is_featured){
                    this.addFeaturedClassToColumn();

                    if(this.$el.find('.' + this.css_classes.featured_badge).length == 0){
                        featured_badge = this.getFeaturedBadgeHtml(params['featured_badge_text']);
                        this.$el.prepend(featured_badge);
                    }
                }
                else {
                    this.removeFeaturedClassToColumn();
                    var featured_badge_node = this.$el.find('.' + this.css_classes.featured_badge);
                    if(featured_badge_node.length != 0){
                        $(featured_badge_node).remove();
                    }
                }

                this.$el.find('.'+this.css_classes.price_block+' .'+this.css_classes.title).text(params['title']);

                this.$el.find('.'+this.css_classes.price_block+' .'+this.css_classes.currency).text(params['currency']);

                this.$el.find('.'+this.css_classes.price_block+' .'+this.price).text(params['price']);

                this.$el.find('.'+this.css_classes.price_block+' .'+this.css_classes.period).text(params['period']);

                this.$el.find('.'+this.css_classes.price_block+' .'+this.css_classes.description).text(params['description']);
            },

            render:function () {
                var params = this.model.get('params');

                var title = params['title'] || 'New Plan',
                    currency = params['currency'] || '$',
                    price = params['price'] || '0',
                    period = params['period'] || '/mo',
                    description = params['description'] || '';

                var featured_badge = '';
                var is_featured = params['make_featured'] == 'true';

                if (is_featured) {
                    featured_badge = this.getFeaturedBadgeHtml(params['featured_badge_text']);
                }
                var output =
                    "<div class='pricingtable-priceblock'>" +
                        featured_badge +
                        "<h3 class='priceblock-plan "+this.css_classes.title+"'>" + title + "</h3>" +
                        "<h4 class='priceblock-price'>" +
                        "<sup class='"+this.css_classes.currency+"'>" + currency + "</sup>" +
                        "<strong class='"+this.css_classes.price+"'>" + price + "</strong>" +
                        "<sub class='"+this.css_classes.period+"'>/" + period + "</sub></h4>" +
                        "<p class='"+this.css_classes.description+"'>" + description + "</p>" +
                    "</div>";

                window.VcPriceBlockView.__super__.render.call(this);

                this.$el.find('.wpb_element_wrapper').append(output);

                this.setEmpty();
                return this;
            },

            addFeaturedClassToColumn : function(){
                var column_model_id = this.model.get('parent_id');
                var column_model = vc.shortcodes.get(column_model_id);
                var column_params = column_model.get('params');

                if(column_params['el_class'] === undefined || column_params['el_class'].indexOf(this.css_classes.featured_column) == -1){
                    column_params['el_class'] = ((column_params['el_class'] || '') + ' ' + this.css_classes.featured_column).trim();
                    column_model.set('params', column_params);
                    column_model.save();

                    if(parseInt(Backbone.VERSION)== 0) {
                        column_model.trigger('change:params', column_model);
                    }
                }
            },

            removeFeaturedClassToColumn : function(){
                var column_model_id = this.model.get('parent_id');
                var column_model = vc.shortcodes.get(column_model_id);
                var column_params = column_model.get('params');

                if(column_params['el_class'] !== undefined && column_params['el_class'].indexOf(this.css_classes.featured_column) != -1){
                    column_params['el_class'] = column_params['el_class'].replace(this.css_classes.featured_column, "").trim();

                    column_model.save();

                    if(parseInt(Backbone.VERSION)== 0) {
                        column_model.trigger('change:params', column_model);
                    }
                }
            },

            getFeaturedBadgeHtml : function(text){
                return text != '' ? "<span class='" + this.css_classes.featured_badge + "'>" + text + "</span>" : '';
            }
        });
    }

    if(window.VcPricingPlanFeatureView === undefined){

        window.VcPricingPlanFeatureView = vc.shortcode_view.extend({

            initialize:function (params) {
                window.VcPricingPlanFeatureView.__super__.initialize.call(this, params);
            },

            changeShortcodeParams:function (model) {
                var params = model.get('params');

                if(params['border'] === 'true') {
                    this.addBorderClass(model);
                }
                else {
                    this.removeBorderClass(model);
                }

                this.$el.find('.feature-title').text(params['title']);

                this.$el.find('.feature-description').text(params['description']);
            },

            render:function () {
                var params = this.model.get('params');

                var title = params['title'] || '',
                    description = params['description'] || '';


                var output =
                    "<div class='pricingtable-feature'>" +
                        "<span class='has-tip tip-bottom feature-title' title=''>" + title + "</span>" +
                        "<span class='feature-description'>" + description + "</span>" +
                    "</div>";

                window.VcPricingPlanFeatureView.__super__.render.call(this);

                this.$el.find('.wpb_element_wrapper').append(output);

                return this;
            },

            addBorderClass : function(model){
                var border_class = 'feature-styling__border';
                var params = model.get('params');

                if(params['el_class'] === undefined || params['el_class'].indexOf(border_class) == -1){
                    params['el_class'] = (params['el_class'] || '') + ' ' + border_class;
                    model.set('params', params);
                    model.save();
                }
            },

            removeBorderClass : function(model){
                var border_class = 'feature-styling__border';
                var params = model.get('params');

                if(params['el_class'] !== undefined && params['el_class'].indexOf(border_class) != -1){
                    params['el_class'] = params['el_class'].replace(border_class, "").trim();
                    model.set('params', params);
                    model.save();
                }
            }
        });
    }

    if(window.VcPricingTableView === undefined){

        window.VcPricingTableView = VcColumnView.extend({

            initialize:function (params) {
                window.VcPricingTableView.__super__.initialize.call(this, params);
            },

            ready:function (e) {
                window.VcPricingTableView.__super__.ready.call(this, e);
                if(this.setDropable === undefined) debugger;
                this.setDropable();
                return this;
            },

            changeShortcodeParams:function (model) {

                var has_children = this.hasNestedModels(model);

                if(!has_children && !model.get('cloned')){

                    var params = model.get('params');
                    var plans_count = (typeof params['plans_count'] == 'string') ? 1 * params['plans_count'] : 0;

                    if (plans_count > 0){
                        var row = vc.shortcodes.create({shortcode:'vc_row_inner', params : { el_class: 'pricingtable-section'}, parent_id:this.model.id});

                        for(var index = 0; index < plans_count; index++){
                            var column = vc.shortcodes.create({shortcode:'vc_column_inner', params:{ width: '1/' + plans_count, el_class : 'pricingtable-column' }, parent_id : row.id});
                            vc.shortcodes.create({shortcode:'vc_price_block', params:{ title: 'Plan ' + (index + 1), price: (index + 1) + '0' }, parent_id : column.id});

                            for(var i = 0; i < 3; i++){
                                vc.shortcodes.create({shortcode:'vc_pricing_plan_feature', params:{ title: 'Feature ' + (i + 1) }, parent_id : column.id});
                            }

                            vc.shortcodes.create({ shortcode: 'vc_button', params : { title: 'Button', color: 'primary', style : 'default' }, parent_id : column.id });
                        }
                    }
                }
            },

            hasNestedModels : function(model){
                var has_children = false;
                var model_id = model.get('id');
                var models = model.collection.models;

                for(var index in models){
                    // If do not check models[index] for object we have error
                    if ( typeof(models[index]) == 'object' ) {

                        if( models[index].get('parent_id') == model_id ) {
                            has_children = true;
                            break;
                        }
                    }
                }

                return has_children;
            }
        });
    }

    if(window.VcLbmnSlider === undefined){

        window.VcLbmnSlider = vc.shortcode_view.extend({

            initialize:function (params) {
                window.VcLbmnSlider.__super__.initialize.call(this, params);
            },

            ready:function (e) {
                window.VcLbmnSlider.__super__.ready.call(this, e);
                return this;
            },

            changeShortcodeParams:function (model) {

                var title = '';
                var post_id = model.get('params')['id'];
                var posts = this.params['id'].value;
                for(var post_title in posts){
                    if(posts[post_title] == post_id) {
                        title = post_title;
                        break;
                    }
                }

                var content_wrapper_node = this.$el.find(".wpb_element_wrapper");

                $(content_wrapper_node).find(".vc_admin_label").remove();

                $(content_wrapper_node).append(
                    '<span class="vc_admin_label admin_label_slider_section_title"><label>Section title</label>: ' + title + '</span>' +
                        '<span class="vc_admin_label admin_label_slider_section_id"><label>Section id</label>: ' + post_id + '</span>');
            }
        });
    }

    if(window.VcElementsCarouselView === undefined){
        window.VcElementsCarouselView = window.VcTabsView.extend({
            createAddTabButton:function () {
                var new_tab_button_id = (+new Date() + '-' + Math.floor(Math.random() * 11));
                this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>');
                this.$add_button = $('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + (window.i18nLocale.add_slide || "Add Slide") + '"></a></li>').appendTo(this.$tabs.find(".tabs_controls"));
            },

            addTab:function (e) {
                e.preventDefault();
                this.new_tab_adding = true;
                var tab_title = window.i18nLocale.slide,
                    tabs_count = this.$tabs.find('[data-element_type=vc_tab]').length,
                    tab_id = (+new Date() + '-' + tabs_count + '-' + Math.floor(Math.random() * 11));
                vc.shortcodes.create({shortcode:'vc_tab', params:{title:tab_title, tab_id:tab_id}, parent_id:this.model.id});
                return false;
            }
        });
    }

    if(window.VcElementsCarouselView35 === undefined){
        window.VcElementsCarouselView35 = window.VcTabsView35.extend({
            createAddTabButton:function () {
                var new_tab_button_id = (+new Date() + '-' + Math.floor(Math.random() * 11));
                this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>');
                this.$tabs.find(".tabs_controls").append('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + (window.i18nLocale.add_slide || "Add Slide") + '"></a></li>');
            },

            addTab:function (e) {
                e.preventDefault();
                this.new_tab_adding = true;
                var tab_title = window.i18nLocale.slide,
                    tabs_count = this.$tabs.tabs("length"),
                    tab_id = (+new Date() + '-' + tabs_count + '-' + Math.floor(Math.random() * 11));
                vc.shortcodes.create({shortcode:'vc_tab', params:{title:tab_title, tab_id:tab_id}, parent_id:this.model.id});
                return false;
            }
        });
    }

})(window.jQuery);

if(typeof window.InlineShortcodeView_vc_tour != "undefined"){
    window.InlineShortcodeView_vc_elements_carousel = window.InlineShortcodeView_vc_tour.extend();
}