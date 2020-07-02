"undefined" == typeof window.shopstorm ? window.shopstorm = {
    apps: {
        productCustomizer: {}
    }
} : "undefined" == typeof window.shopstorm.apps ? window.shopstorm.apps = {
    productCustomizer: {}
} : "undefined" == typeof window.shopstorm.apps.productCustomizer && (window.shopstorm.apps.productCustomizer = {}), window.shopstorm.apps.productCustomizer.jqueryLoadedCallback = function (t) {
    var e = {};
    t.fn.fontselect = function (o) {
        var r = function (t, e) {
            return function () {
                return t.apply(e, arguments)
            }
        },
            i = {
                style: "font-select",
                placeholder: "Select a font",
                placeholderSearch: "Search...",
                searchable: !0,
                lookahead: 2,
                googleApi: "https://fonts.googleapis.com/css?family=",
                localFontsUrl: "/fonts/",
                systemFonts: "Arial|Helvetica+Neue|Courier+New|Times+New+Roman|Comic+Sans+MS|Verdana|Impact".split("|"),
                googleFonts: "Abril+Fatface|Aclonica|Alfa+Slab+One|Allan|Amarante|Annie+Use+Your+Telescope|Anonymous+Pro|Allerta+Stencil|Allerta|Amaranth|Anton|Arbutus|Architects+Daughter|Archivo+Black|Arimo|Artifika|Arvo|Asset|Astloch|Audiowide|Bangers|Baumans|Bentham|Bevan|Bigshot+One|Black+Ops+One|Bowlby+One|Bowlby+One+SC|Brawler|Bubblegum+Sans|Buda:300|Butcherman|Butterfly+Kids|Cabin|Caesar+Dressing|Calligraffitti|Candal|Cantarell|Cardo|Carter+One|Caudex|Cedarville+Cursive|Changa+One|Cherry+Cream+Soda|Chewy|Coda|Codystar|Comfortaa|Coming+Soon|Copse|Corben|Cousine|Covered+By+Your+Grace|Crafty+Girls|Crimson+Text|Crushed|Cuprum|Damion|Dancing+Script|Dawning+of+a+New+Day|Days+One|Didact+Gothic|Diplomata|Droid+Sans|Droid+Serif|EB+Garamond|Ewert|Expletus+Sans|Faster+One|Fontdiner+Swanky|Forum|Francois+One|Fredoka+One|Fugaz+One|Glass+Antiqua|Geo|Give+You+Glory|Goblin+One|Gorditas|Goudy+Bookletter+1911|Gravitas+One|Gruppo|Hammersmith+One|Hanalei|Henny+Penny|Holtwood+One+SC|Homemade+Apple|Inconsolata|Indie+Flower|Irish+Grover|Istok+Web|Josefin+Sans|Josefin+Slab|Judson|Jura|Just+Another+Hand|Just+Me+Again+Down+Here|Kameron|Kenia|Kranky|Kreon|Kristi|La+Belle+Aurore|Lato|League+Script|Lekton|Limelight|Lobster|Lobster+Two|Lora|Love+Ya+Like+A+Sister|Loved+by+the+King|Luckiest+Guy|Maiden+Orange|Mako|Maven+Pro|Maven+Pro:900|Meddon|MedievalSharp|Megrim|Merriweather|Metrophobic|Michroma|Miltonian+Tattoo|Miltonian|Modern+Antiqua|Monofett|Molengo|Montserrat:300|Montserrat|Montserrat:700|Mountains+of+Christmas|Muli:300|Muli|Mystery+Quest|Neucha|Neuton|News+Cycle|Nixie+One|Nobile|Nova+Cut|Nova+Flat|Nova+Mono|Nova+Oval|Nova+Round|Nova+Script|Nova+Slim|Nova+Square|Nunito|Old+Standard+TT|Open+Sans:300|Open+Sans|Open+Sans:600|Open+Sans:800|Open+Sans+Condensed:300|Orbitron|Orbitron:500|Orbitron:700|Orbitron:900|Oswald|Over+the+Rainbow|Piedra|Prociono|Questrial|Reenie+Beanie|Pacifico|Patrick+Hand|Paytone+One|Permanent+Marker|Philosopher|Play|Playfair+Display|Podkova|Poiret+One|Press+Start+2P|Puritan|Quattrocento|Quattrocento+Sans|Racing+Sans+One|Radley|Raleway:100|Redressed|Ribeye|Ribeye+Marrow|Risque|Rock+Salt|Rokkitt|Ruslan+Display|Schoolbell|Shadows+Into+Light|Shanti|Sigmar+One|Six+Caps|Slackey|Smythe|Sniglet|Sniglet:800|Special+Elite|Stardos+Stencil|Sue+Elen+Francisco|Sunshiney|Swanky+and+Moo+Moo|Syncopate|Tangerine|Tenor+Sans|Terminal+Dosis+Light|The+Girl+Next+Door|Tinos|Ubuntu|Ultra|Unkempt|UnifrakturCook:bold|UnifrakturMaguntia|Varela|Varela+Round|Vast+Shadow|Vibur|Vollkorn|VT323|Waiting+for+the+Sunrise|Wallpoet|Walter+Turncoat|Wire+One|Yanone+Kaffeesatz|Yeseva+One|Zeyada".split("|")
            },
            s = function () {
                function o(e, o) {
                    o.systemFonts || (o.systemFonts = []), o.localFonts || (o.localFonts = []), o.googleFonts || (o.googleFonts = []), this.options = o, this.$original = t(e), this.setupHtml(), this.getVisibleFonts(), this.bindEvents(), this.query = "", this.keyActive = !1, this.searchBoxHeight = 0;
                    var r = this.$original.val();
                    r && (this.updateSelected(), this.addFontLink(r))
                }
                return o.prototype = {
                    keyDown: function (e) {
                        function o(t) {
                            t.preventDefault(), t.stopPropagation()
                        }
                        if (this.keyActive = !0, 27 == e.keyCode) return o(e), void this.toggleDropdown("hide");
                        if (38 == e.keyCode) {
                            o(e);
                            var r = t("li.active", this.$results),
                                i = r.prev("li");
                            return void (i.length > 0 && (r.removeClass("active"), this.$results.scrollTop(i.addClass("active")[0].offsetTop - this.searchBoxHeight)))
                        }
                        if (40 == e.keyCode) {
                            o(e);
                            var r = t("li.active", this.$results),
                                s = r.next("li");
                            return void (s.length > 0 && (r.removeClass("active"), this.$results.scrollTop(s.addClass("active")[0].offsetTop - this.searchBoxHeight)))
                        }
                        if (13 == e.keyCode) return o(e), void t("li.active", this.$results).trigger("click");
                        this.query += String.fromCharCode(e.keyCode).toLowerCase();
                        var n = t("li[data-query^='" + this.query + "']").first();
                        n.length > 0 && (t("li.active", this.$results).removeClass("active"), this.$results.scrollTop(n.addClass("active")[0].offsetTop))
                    },
                    keyUp: function () {
                        this.keyActive = !1
                    },
                    bindEvents: function () {
                        var e = this;
                        t("li", this.$results).click(r(this.selectFont, this)).mouseover(r(this.activateFont, this)), this.$select.click(r(function () {
                            e.toggleDropdown("show")
                        }, this)), this.$original.on("setFont", function (o, r, i) {
                            i = i || 400;
                            var s = r.replace(/ /g, "+") + (400 == i ? "" : ":" + i),
                                n = t("li[data-value='" + s + "']", e.$results);
                            0 == n.length && (s = r.replace(/ /g, "+")), n = t("li[data-value='" + s + "']", e.$results), t("li.active", e.$results).removeClass("active"), n.addClass("active"), e.$original.val(s), e.updateSelected(), e.addFontLink(n.data("value"))
                        }), this.$original.on("change", function () {
                            e.updateSelected(), e.addFontLink(t("li.active", e.$results).data("value"))
                        }), this.options.searchable && this.$input.on("keyup", function () {
                            var o = this.value.toLowerCase();
                            t("li", e.$results).each(function () {
                                -1 == t(this).text().toLowerCase().indexOf(o) ? t(this).hide() : t(this).show()
                            })
                        }), t(document).on("click", function (o) {
                            0 === t(o.target).closest("." + e.options.style).length && e.toggleDropdown("hide")
                        })
                    },
                    toggleDropdown: function (t) {
                        "hide" === t ? (this.$element.off("keydown keyup"), this.query = "", this.keyActive = !1, this.$element.removeClass("font-select-active"), this.$drop.hide(), clearInterval(this.visibleInterval)) : (this.$element.on("keydown", r(this.keyDown, this)), this.$element.on("keyup", r(this.keyUp, this)), this.$element.addClass("font-select-active"), this.$drop.show(), this.visibleInterval = setInterval(r(this.getVisibleFonts, this), 500), this.searchBoxHeight = this.$search.outerHeight(), this.moveToSelected())
                    },
                    selectFont: function () {
                        var e = t("li.active", this.$results).data("value");
                        this.$original.val(e).change(), this.updateSelected(), this.toggleDropdown("hide")
                    },
                    moveToSelected: function () {
                        var e = this.$original.val().replace(/ /g, "+"),
                            o = e ? t("li[data-value='" + e + "']", this.$results) : o = t("li", this.$results).first();
                        this.$results.scrollTop(o.addClass("active")[0].offsetTop - this.searchBoxHeight)
                    },
                    activateFont: function (e) {
                        this.keyActive || (t("li.active", this.$results).removeClass("active"), t(e.target).addClass("active"))
                    },
                    updateSelected: function () {
                        var e = this.$original.val();
                        t("span", this.$element).text(this.toReadable(e)).css(this.toStyle(e))
                    },
                    setupHtml: function () {
                        this.$original.hide(), this.$element = t("<div>", {
                            "class": this.options.style
                        }), this.$select = t('<span tabindex="0">' + this.options.placeholder + "</span>"), this.$search = t("<div>", {
                            "class": "fs-search"
                        }), this.$input = t("<input>", {
                            type: "text"
                        }), this.options.placeholderSearch && this.$input.attr("placeholder", this.options.placeholderSearch), this.$search.append(this.$input), this.$drop = t("<div>", {
                            "class": "fs-drop"
                        }), this.$results = t("<ul>", {
                            "class": "fs-results"
                        }), this.$original.after(this.$element.append(this.$select, this.$drop)), this.options.searchable && this.$drop.append(this.$search), this.$drop.append(this.$results.append(this.fontsAsHtml())).hide()
                    },
                    fontsAsHtml: function () {
                        var t, e, o, r, i = "",
                            s = this.options.systemFonts,
                            n = this.options.localFonts,
                            a = this.options.googleFonts;
                        for (t = 0; t < s.length; t++) e = this.toReadable(s[t]), o = this.toStyle(s[t]), r = "font-family:" + o["font-family"], (n.length > 0 || a.length > 0) && t == s.length - 1 && (r += ";border-bottom:1px solid #444"), i += '<li data-value="' + s[t] + '" data-query="' + s[t].toLowerCase() + '" style="' + r + '">' + e + "</li>";
                        for (t = 0; t < n.length; t++) e = this.toReadable(n[t]), o = this.toStyle(n[t]), r = "font-family:" + o["font-family"], a.length > 0 && t == n.length - 1 && (r += ";border-bottom:1px solid #444"), i += '<li data-value="' + n[t] + '" data-query="' + n[t].toLowerCase() + '" style="' + r + '">' + e + "</li>";
                        for (t = 0; t < a.length; t++) e = this.toReadable(a[t]), o = this.toStyle(a[t]), r = "font-family:" + o["font-family"] + ";font-weight:" + o["font-weight"], i += '<li data-value="' + a[t] + '" data-query="' + a[t].toLowerCase() + '" style="' + r + '">' + e + "</li>";
                        return i
                    },
                    toReadable: function (t) {
                        return t.replace(/[\+|:]/g, " ")
                    },
                    toStyle: function (t) {
                        var e = t.split(":");
                        return {
                            "font-family": "'" + this.toReadable(e[0]) + "'",
                            "font-weight": e[1] || 400
                        }
                    },
                    getVisibleFonts: function () {
                        if (!this.$results.is(":hidden")) {
                            var e = this,
                                o = this.$results.scrollTop(),
                                r = o + this.$results.height();
                            if (this.options.lookahead) {
                                var i = t("li", this.$results).first().height();
                                r += i * this.options.lookahead
                            }
                            t("li:visible", this.$results).each(function () {
                                var i = t(this).position().top + o,
                                    s = i + t(this).height();
                                s >= o && r >= i && e.addFontLink(t(this).data("value"))
                            })
                        }
                    },
                    addFontLink: function (o) {
                        e[o] || (e[o] = !0, this.options.googleFonts.indexOf(o) > -1 ? t("link:last").after('<link href="' + this.options.googleApi + o + '" rel="stylesheet" type="text/css">') : this.options.localFonts.indexOf(o) > -1 && (o = this.toReadable(o), t("head").append("<style> @font-face { font-family:'" + o + "'; font-style:normal; font-weight:400; src:local('" + o + "'), url('" + this.options.localFontsUrl + o + ".woff') format('woff'); } </style>")))
                    }
                }, o
            }();
        return this.each(function () {
            return o && t.extend(i, o), new s(this, i)
        })
    }
},
    function (t, e, o, r) {
        function s(t, e) {
            for (t = t.split("."), e = e.split("."), i = 0, ix = Math.max(t.length, e.length); i < ix; i++) {
                var o = parseInt(t[i]),
                    r = parseInt(e[i]);
                if (o > r || isNaN(r)) return 1;
                if (r > o || isNaN(o)) return -1
            }
            return 0
        }
        var n, a, p = !1;
        if (n = "undefined" != typeof t.shopstorm && "undefined" != typeof t.shopstorm.apps && "undefined" != typeof t.shopstorm.apps.productCustomizer && "undefined" != typeof t.shopstorm.apps.productCustomizer.$ ? t.shopstorm.apps.productCustomizer.$ : t.jQuery, !n || 1 == s(o, n.fn.jquery) || r(n, p)) {
            var u = e.createElement("script");
            u.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js", u.onload = u.onreadystatechange = function () {
                p || (a = this.readyState) && "loaded" != a && "complete" != a || (n = jQuery.noConflict(!0), r(n, p = !0), n(u).remove())
            };
            try {
                e.body.appendChild(u)
            } catch (d) {
                try {
                    e.documentElement.childNodes[0].appendChild(u)
                } catch (d) {
                    console.warn("Shopify Product Customizer: error loading")
                }
            }
        }
    }(window, document, "2.0.1", function (t) {
        if (console.log("Product Customizer Version 2.0.1"), window.shopstorm = window.shopstorm || {}, window.shopstorm.shop = window.shopstorm.shop || {}, window.shopstorm.shop.moneyFormat = window.shopstorm.shop.moneyFormat || null, window.shopstorm.apps = window.shopstorm.apps || {}, window.shopstorm.apps.productCustomizer = window.shopstorm.apps.productCustomizer || {}, window.shopstorm.apps.productCustomizer.$ = window.shopstorm.apps.productCustomizer.$ || t, window.shopstorm.apps.productCustomizer.jQueries = window.shopstorm.apps.productCustomizer.jQueries || [t], window.productCustomizerCallbacks = window.productCustomizerCallbacks || {}, "function" == typeof window.shopstorm.apps.productCustomizer.jqueryLoadedCallback && window.shopstorm.apps.productCustomizer.jqueryLoadedCallback(t), "undefined" == typeof shopstorm.apps.productCustomizer.collectOptionsCost && (shopstorm.apps.productCustomizer.collectOptionsCost = function (e, o) {
            o = o || !1;
            var r = t('.product-customizer-options[data-product-id="' + e + '"]'),
                i = [];
            return "undefined" != typeof shopstorm.apps.productCustomizer.options.productOptions && shopstorm.apps.productCustomizer.options.productOptions[e] && t.each(shopstorm.apps.productCustomizer.options.productOptions[e], function (s, n) {
                var a, p = n.fieldKey,
                    u = n.name,
                    d = s + 1;
                if (!u && p.indexOf("_") > -1 && (u = p.split("_")[1]), a = t(r.data("version") && shopstorm.apps.versionCompare(r.data("version"), "1.6.3", ">") ? "#" + e + "_option_" + d : "#" + e + "_option_" + p.split("_")[0]), !a.closest(".product-customizer-option").hasClass("conditional-logic-hidden")) {
                    if (n.option_prices) {
                        var c = n.option_prices.split(",");
                        if ("SELECT" == a.prop("tagName")) {
                            var l = 0;
                            if (0 == a.find("[data-index]").length) {
                                var m = a.prop("selectedIndex");
                                "undefined" != typeof m && (l += parseInt(c[m]) || 0)
                            } else t.each(a.find(":selected"), function (e, o) {
                                var r = t(o).data("index");
                                l += parseInt(c[r]) || 0
                            });
                            l = shopstorm.apps.productCustomizer.getOptionCost(e, a.attr("id"), p, l), l && i.push({
                                name: u,
                                cost: parseInt(l),
                                id: a.attr("id")
                            })
                        } else if (a.closest(".option-type-checkbox_group, .option-type-radio").length > 0) {
                            var l = 0;
                            t.each(a.closest(".option-type-checkbox_group, .option-type-radio").find("input:checked"), function (e, o) {
                                var r = t(o).attr("id").split("_").pop();
                                l += parseInt(c[r]) || 0
                            }), l = shopstorm.apps.productCustomizer.getOptionCost(e, a.attr("id"), p, l), l && i.push({
                                name: u,
                                cost: parseInt(l),
                                id: a.attr("id")
                            })
                        }
                    } else if (n.price && (!a.is(":checkbox") && a.val().trim() || a.is(":checkbox") && a.is(":checked") || o && a.is(":visible") && a.prop("required"))) {
                        var l = shopstorm.apps.productCustomizer.getOptionCost(e, a.attr("id"), p, parseInt(n.price));
                        l && i.push({
                            name: u,
                            cost: parseInt(l),
                            id: a.attr("id")
                        })
                    }
                    d++
                }
            }), i
        }), "undefined" == typeof shopstorm.apps.versionCompare && (shopstorm.apps.versionCompare = function (t, e, o) {
            if (o = o || "<=>", t == e) switch (o) {
                case "<=>":
                    return 0;
                case ">":
                    return !1;
                case ">=":
                    return !0
            }
            for (t = t.split("."), e = e.split("."), i = 0, ix = Math.max(t.length, e.length); i < ix; i++) {
                var r = parseInt(t[i]),
                    s = parseInt(e[i]);
                switch (o) {
                    case "<=>":
                        if (r > s || isNaN(s)) return 1;
                        if (s > r || isNaN(r)) return -1;
                        break;
                    case ">":
                    case ">=":
                        if (r > s || isNaN(s)) return !0;
                        if (s > r || isNaN(r)) return !1
                }
            }
        }), "undefined" == typeof shopstorm.apps.productCustomizer.getOptionCost && (shopstorm.apps.productCustomizer.getOptionCost = function (e, o, r, i) {
            var s = 100;
            return "autodeliver" == t(".rc_container input.rc_radio:checked").val() && (s -= shopstorm.apps.productCustomizer.options.discount), i * s / 100
        }), "undefined" == typeof shopstorm.apps.productCustomizer.sumOptionsCost && (shopstorm.apps.productCustomizer.sumOptionsCost = function (e, o) {
            o = o || !1;
            var r = 0;
            return t.isArray(e) || (e = shopstorm.apps.productCustomizer.collectOptionsCost(e, o)), t.each(e, function (t, e) {
                r += e.cost
            }), r
        }), "undefined" == typeof shopstorm.apps.productCustomizer.generatePricingItemUniqueId && (shopstorm.apps.productCustomizer.generatePricingItemUniqueId = function () {
            return Math.floor(1e15 * Math.random())
        }), "undefined" == typeof shopstorm.apps.productCustomizer.getMainProductQuantity && (shopstorm.apps.productCustomizer.getMainProductQuantity = function (e) {
            var o = t('.product-customizer-options[data-product-id="' + e + '"]'),
                r = o.closest('form[action="/cart/add"], form[action^="/cart/add?"]'),
                i = 1,
                s = r.find("[name=quantity]");
            return s.length > 0 && s.val().match(/^\d+$/) && (i = parseInt(s.val())), i
        }), "undefined" == typeof shopstorm.apps.productCustomizer.setupMainProductPricingProperties && (shopstorm.apps.productCustomizer.setupMainProductPricingProperties = function (e, o) {
            var r = t('.product-customizer-options[data-product-id="' + e + '"]'),
                i = r.closest('form[action="/cart/add"], form[action^="/cart/add?"]'),
                s = shopstorm.apps.productCustomizer.collectOptionsCost(e),
                n = shopstorm.apps.productCustomizer.sumOptionsCost(s),
                a = n * shopstorm.apps.productCustomizer.getMainProductQuantity(e);
            return a ? (0 == r.find('input[name="properties[_pc_pricing_ref]"]').length && r.append('<input type="hidden" name="properties[_pc_pricing_ref]" value="">'), 0 == r.find('input[name="properties[_pc_pricing_qty]"]').length && r.append('<input type="hidden" name="properties[_pc_pricing_qty]" value="">'), i.find('input[name="properties[_pc_pricing_ref]"]').val(o), i.find('input[name="properties[_pc_pricing_qty]"]').val(n), !0) : (t('input[name^="properties[_pc_pricing"]').remove(), !1)
        }), "undefined" == typeof shopstorm.apps.productCustomizer.addOptionPricingItemToCart && (shopstorm.apps.productCustomizer.addOptionPricingItemToCart = function (e, o) {
            var r = t('.product-customizer-options[data-product-id="' + e + '"]').eq(0),
                i = r.closest('form[action="/cart/add"], form[action^="/cart/add?"]'),
                s = shopstorm.apps.productCustomizer.collectOptionsCost(e),
                n = shopstorm.apps.productCustomizer.sumOptionsCost(s);
            if (o = o || shopstorm.apps.productCustomizer.generatePricingItemUniqueId(), i.data("product-customizer-doing-submit") && shopstorm.apps.productCustomizer.preventDuplicateFormSubmissions) return !1;
            if (i.data("product-customizer-doing-submit", !0), shopstorm.apps.productCustomizer.formHasMissingRequired(i)) return i.data("product-customizer-doing-submit", !1), !1;
            var a = n * shopstorm.apps.productCustomizer.getMainProductQuantity(e);
            if (!shopstorm.apps.productCustomizer.setupMainProductPricingProperties(e, o)) return i.data("product-customizer-doing-submit", !1), !0;
            var p = i.serializeArray();
            if (p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "quantity", a), p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "id", shopstorm.apps.productCustomizer.pricingVariantId), p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "properties[_pc_pricing_qty]", null), p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "id[]", null), t.each(i.find("input:file:visible"), function (e, o) {
                t(o).val() && (p = shopstorm.apps.productCustomizer.updateSerializedArray(p, t(o).attr("name"), t(o).val().replace("C:\\fakepath\\", "")))
            }), t.each(s, function (t, e) {
                p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "properties[" + e.name + "]", " (" + e.cost + ")", "append")
            }), shopstorm.apps.productCustomizer.options.productTitles[e]) {
                t.each(p, function (t, e) {
                    e.name && 0 == e.name.indexOf("properties[") && -1 == e.name.indexOf("properties[_") && "properties[subscription_id]" != e.name && "properties[shipping_interval_frequency]" != e.name && "properties[shipping_interval_unit_type]" != e.name && (p[t].name = e.name.replace("properties[", "properties[_"))
                });
                var u = shopstorm.apps.productCustomizer.customizationsForText ? shopstorm.apps.productCustomizer.customizationsForText : "Customizations for";
                p = shopstorm.apps.productCustomizer.updateSerializedArray(p, "properties[" + u + "]", shopstorm.apps.productCustomizer.options.productTitles[e])
            }
            return response = t.ajax({
                method: "POST",
                url: "/cart/add.js",
                data: t.param(p),
                async: !1,
                dataType: "json"
            }), 200 != response.status && console.warn("Shopify Product Customizer: dynamic pricing product missing"), !0
        }), "undefined" == typeof shopstorm.apps.productCustomizer.updateSerializedArray && (shopstorm.apps.productCustomizer.updateSerializedArray = function (e, o, r, i) {
            var s = [],
                n = !1;
            return t.each(e, function (t, e) {
                e.name == o ? (n = !0, null != r && ("append" == i ? e.value += r : e.value = r, s.push(e))) : s.push(e)
            }), n || null == r || "append" == i || s.push({
                name: o,
                value: r
            }), s
        }), "undefined" == typeof shopstorm.apps.productCustomizer.formHasFileToUpload && (shopstorm.apps.productCustomizer.formHasFileToUpload = function (e) {
            var o = !1;
            return t.each(t(e).find("input[name^=properties]:file:visible"), function () {
                return t(this).val() ? (o = !0, !1) : void 0
            }), o
        }), "undefined" == typeof shopstorm.apps.productCustomizer.formHasMissingRequired && (shopstorm.apps.productCustomizer.formHasMissingRequired = function (e) {
            var o, r = !1;
            return t.each(t(e).find("[name^=properties][required]:visible"), function (e, o) {
                return !t(o).val() && !t(o).is(":checkbox, :radio") || t(o).is(":checkbox") && !t(o).is(":checked") || t(o).is(":radio") && 0 == t(o).closest("form").find('input[name="' + t(o).attr("name") + '"]:radio:checked').length ? (r = !0, !1) : void 0
            }), o = t(e).find(".option-type-checkbox_group[data-min-selections]").not(".conditional-logic-hidden"), o.each(function (e, o) {
                var i = Math.min(t(o).data("min-selections"), t(o).find("input:checkbox").length);
                i > 0 && t(o).find("input:checkbox:checked").length < i && (r = !0)
            }), r
        }), "undefined" == typeof shopstorm.apps.productCustomizer.formMarkMissingRequired && (shopstorm.apps.productCustomizer.formMarkMissingRequired = function (e) {
            var o, r, i = !1;
            return t.each(t(e).find("[name^=properties][required]"), function (e, r) {
                t(r).is(":checkbox, :radio") ? t(r).is(":checkbox") && !t(r).is(":checked") || t(r).is(":radio") && 0 == t(r).closest("form").find('input[name="' + t(r).attr("name") + '"]:radio:checked').length ? ("SPAN" != t(r).parent().prop("tagName") && t(r).wrap("<span></span>"), t(r).parent().addClass("missing-required"), t(r).parent().css("border", "1px solid red"), i = !0, o || (o = t(r).closest(".product-customizer-option"))) : t(r).parent().hasClass("missing-required") && (t(r).parent().removeClass("missing-required"), t(r).parent().css("border", "initial")) : t(r).val() ? t(r).hasClass("missing-required") && (t(r).css("border", t(r).data("original-border")), t(r).removeClass("missing-required")) : (t(r).hasClass("missing-required") || (t(r).data("original-border", t(r).css("border")), t(r).css("border", "1px solid red"), t(r).addClass("missing-required")), i = !0, o || (o = t(r).closest(".product-customizer-option")))
            }), r = t(e).find(".option-type-checkbox_group[data-min-selections]").not(".conditional-logic-hidden"), r.each(function (e, r) {
                var s = Math.min(t(r).data("min-selections"), t(r).find("input:checkbox").length),
                    n = t(r).find("ul"),
                    a = t(r).find(".product-customizer-selections-message");
                s > 0 && t(r).find("input:checkbox:checked").length < s ? (n.hasClass("missing-required") || (n.addClass("missing-required"), n.data("original-border", t(r).css("border")), n.data("original-border-radius", t(r).css("border-radius")), n.data("original-padding", t(r).css("padding")), n.css("border", "1px solid red"), n.css("border-radius", "3px"), n.css("padding", "0 5px"), a.data("original-color", a.css("color")), a.css("color", "red")), i = !0, o || (o = t(r))) : s > 0 && t(r).find("input:checkbox:checked").length >= s && n.hasClass("missing-required") && (a.css("color", a.data("original-color")), n.css("border-radius", n.data("original-border-radius")), n.css("border", n.data("original-border")), n.css("padding", n.data("original-padding")), n.removeClass("missing-required"))
            }), o && o.length > 0 && "undefined" != typeof o[0].scrollIntoViewIfNeeded && o[0].scrollIntoViewIfNeeded(), i
        }), "undefined" == typeof shopstorm.apps.productCustomizer.updateCartPricingItemsQuantities && (shopstorm.apps.productCustomizer.updateCartPricingItemsQuantities = function (e) {
            var o = e.find("[data-product-customizer-pricing-ref][data-product-customizer-pricing-qty]");
            t.each(o, function (e, o) {
                var r = t(o).data("product-customizer-pricing-ref"),
                    i = t(o).find('[name="updates[]"]').val(),
                    s = t(o).data("product-customizer-pricing-qty"),
                    n = t(o).siblings("[data-product-customizer-pricing-ref=" + r + "]:not([data-product-customizer-pricing-qty])");
                n.length > 0 && parseInt(i) == i && n.find('[name="updates[]"]').val(i * s)
            })
        }), "undefined" == typeof shopstorm.apps.productCustomizer.changeCartPricingItemQuantity && (shopstorm.apps.productCustomizer.changeCartPricingItemQuantity = function (e, o, r) {
            o = "undefined" == typeof o ? e.find('[name="updates[]"]').val() : o;
            var i = e.data("line"),
                s = e.data("product-customizer-pricing-ref"),
                n = e.data("product-customizer-pricing-qty"),
                a = e.siblings("[data-product-customizer-pricing-ref=" + s + "]:not([data-product-customizer-pricing-qty])");
            if (a.length > 0 && parseInt(o) == o) {
                var p = a.data("line");
                t.ajax({
                    method: "GET",
                    url: "/cart/change?line=" + p + "&quantity=" + o * n,
                    async: "undefined" != typeof r
                }).always(function () {
                    "undefined" != typeof r && (i > p && 0 == o && i--, r(i))
                })
            } else "undefined" != typeof r && r(i)
        }), "undefined" == typeof shopstorm.apps.productCustomizer.bindCartRemove && (shopstorm.apps.productCustomizer.bindCartRemove = function (e, o) {
            "string" != typeof e && (e = e.join(" .product-customizer-cart-remove, ")), e += " .product-customizer-cart-remove", t(document).on("click", e, function () {
                var e = t(this).closest("[data-product-customizer-pricing-ref][data-product-customizer-pricing-qty]");
                return e.length > 0 ? (shopstorm.apps.productCustomizer.changeCartPricingItemQuantity(e, 0, o), !1) : void 0
            })
        }), "undefined" == typeof shopstorm.apps.productCustomizer.browserValidatesRequired) {
            var e, o = function () {
                var t = shopstorm.apps.productCustomizer.Modernizr;
                return t.input.required && t.formvalidation
            };
            shopstorm.apps.productCustomizer.browserValidatesRequired = o, shopstorm.apps.productCustomizer.isSafari = function () {
                return !o()
            }, e = window.Modernizr, ! function (t, e) {
                function o(t, e) {
                    return typeof t === e
                }

                function r() {
                    var t, e, r, i, s, n, p;
                    for (var c in a)
                        if (a.hasOwnProperty(c)) {
                            if (t = [], e = a[c], e.name && (t.push(e.name.toLowerCase()), e.options && e.options.aliases && e.options.aliases.length))
                                for (r = 0; r < e.options.aliases.length; r++) t.push(e.options.aliases[r].toLowerCase());
                            for (i = o(e.fn, "function") ? e.fn() : e.fn, s = 0; s < t.length; s++) n = t[s], p = n.split("."), 1 === p.length ? u[p[0]] = i : (!u[p[0]] || u[p[0]] instanceof Boolean || (u[p[0]] = new Boolean(u[p[0]])), u[p[0]][p[1]] = i), d.push((i ? "" : "no-") + p.join("-"))
                        }
                }

                function i() {
                    return "function" != typeof e.createElement ? e.createElement(arguments[0]) : l ? e.createElementNS.call(e, "http://www.w3.org/2000/svg", arguments[0]) : e.createElement.apply(e, arguments)
                }

                function s() {
                    var t = e.body;
                    return t || (t = i(l ? "svg" : "body"), t.fake = !0), t
                }

                function n(t, o, r, n) {
                    var a, p, u, d, l = "modernizr",
                        m = i("div"),
                        h = s();
                    if (parseInt(r, 10))
                        for (; r--;) u = i("div"), u.id = n ? n[r] : l + (r + 1), m.appendChild(u);
                    return a = i("style"), a.type = "text/css", a.id = "s" + l, (h.fake ? h : m).appendChild(a), h.appendChild(m), a.styleSheet ? a.styleSheet.cssText = t : a.appendChild(e.createTextNode(t)), m.id = l, h.fake && (h.style.background = "", h.style.overflow = "hidden", d = c.style.overflow, c.style.overflow = "hidden", c.appendChild(h)), p = o(m, t), h.fake ? (h.parentNode.removeChild(h), c.style.overflow = d, c.offsetHeight) : m.parentNode.removeChild(m), !!p
                }
                var a = [],
                    p = {
                        _version: "3.5.0",
                        _config: {
                            classPrefix: "",
                            enableClasses: !0,
                            enableJSClass: !0,
                            usePrefixes: !0
                        },
                        _q: [],
                        on: function (t, e) {
                            var o = this;
                            setTimeout(function () {
                                e(o[t])
                            }, 0)
                        },
                        addTest: function (t, e, o) {
                            a.push({
                                name: t,
                                fn: e,
                                options: o
                            })
                        },
                        addAsyncTest: function (t) {
                            a.push({
                                name: null,
                                fn: t
                            })
                        }
                    },
                    u = function () { };
                u.prototype = p, u = new u;
                var d = [],
                    c = e.documentElement,
                    l = "svg" === c.nodeName.toLowerCase(),
                    m = p.testStyles = n;
                u.addTest("formvalidation", function () {
                    var e = i("form");
                    if (!("checkValidity" in e && "addEventListener" in e)) return !1;
                    if ("reportValidity" in e) return !0;
                    var o, r = !1;
                    return u.formvalidationapi = !0, e.addEventListener("submit", function (e) {
                        (!t.opera || t.operamini) && e.preventDefault(), e.stopPropagation()
                    }, !1), e.innerHTML = '<input name="modTest" required="required" /><button></button>', m("#modernizr form{position:absolute;top:-99999em}", function (t) {
                        t.appendChild(e), o = e.getElementsByTagName("input")[0], o.addEventListener("invalid", function (t) {
                            r = !0, t.preventDefault(), t.stopPropagation()
                        }, !1), u.formvalidationmessage = !!o.validationMessage, e.getElementsByTagName("button")[0].click()
                    }), r
                });
                var h = i("input"),
                    f = "autocomplete autofocus list placeholder max min multiple pattern required step".split(" "),
                    g = {};
                u.input = function (e) {
                    for (var o = 0, r = e.length; r > o; o++) g[e[o]] = !!(e[o] in h);
                    return g.list && (g.list = !(!i("datalist") || !t.HTMLDataListElement)), g
                }(f), r(), delete p.addTest, delete p.addAsyncTest;
                for (var v = 0; v < u._q.length; v++) u._q[v]();
                t.Modernizr = u
            }(window, document), shopstorm.apps.productCustomizer.Modernizr = window.Modernizr, window.Modernizr = e
        }
        "undefined" == typeof shopstorm.apps.productCustomizer.hidePricingItemRowHelper && (shopstorm.apps.productCustomizer.hidePricingItemRowHelper = function (t) {
            var e = "";
            return t.properties && t.properties._pc_pricing_ref && "undefined" == typeof t.properties._pc_pricing_qty && (e = "display: none;"), e
        }), "undefined" == typeof shopstorm.apps.productCustomizer.cartRowDataHelper && (shopstorm.apps.productCustomizer.cartRowDataHelper = function (t, e) {
            var o = ' data-line="' + e + '"';
            return t.properties && t.properties._pc_pricing_ref && (o += ' data-product-customizer-pricing-ref="' + t.properties._pc_pricing_ref + '"'), t.properties && t.properties._pc_pricing_qty && (o += ' data-product-customizer-pricing-qty="' + t.properties._pc_pricing_qty + '"'), o
        }), "undefined" == typeof shopstorm.apps.productCustomizer.lineItemPropertiesHelper && (shopstorm.apps.productCustomizer.lineItemPropertiesHelper = function (e, o) {
            o = o || "before";
            var r = [],
                i = "";
            return e.properties && t.each(e.properties, function (t, e) {
                var o = "";
                return e ? "_" == t.charAt(0) ? (i += '<span style="display: none;" class="product-customizer-line-item-prop" data-prop-name="' + t + '">' + t + ": " + e + "</span>", !0) : (o = '<span class="product-customizer-line-item-prop" data-prop-name="' + t + '">' + t + ": ", o += e.indexOf("/uploads/") > -1 ? '<a href="' + e + '">Click to see</a>' : e.replace(/\n/g, "<br/>"), o += "</span>", void r.push(o)) : !0
            }), ("before" == o ? "<br/>" : "") + r.join("<br/>") + ("after" == o ? "<br/>" : "") + i
        }), "undefined" == typeof shopstorm.apps.productCustomizer.removeFromCartHrefHelper && (shopstorm.apps.productCustomizer.removeFromCartHrefHelper = function (t, e, o) {
            return o = o || "/cart/change?line=" + e + "&amp;quantity=0", t.properties && t.properties._pc_pricing_ref && t.properties._pc_pricing_qty ? "#" + e : o
        }), "undefined" == typeof shopstorm.apps.productCustomizer.removeFromCartClassHelper && (shopstorm.apps.productCustomizer.removeFromCartClassHelper = function (t, e) {
            return e = e || "", t.properties && t.properties._pc_pricing_ref && t.properties._pc_pricing_qty ? "product-customizer-cart-remove" : e
        }), "undefined" == typeof shopstorm.apps.productCustomizer.itemLinePriceHelper && (shopstorm.apps.productCustomizer.itemLinePriceHelper = function (e, o) {
            var r = o.line_price;
            return o.properties && o.properties._pc_pricing_ref && o.properties._pc_pricing_qty && t.each(e, function (t, e) {
                return e.properties && "undefined" == typeof e.properties._pc_pricing_qty && e.properties._pc_pricing_ref == o.properties._pc_pricing_ref ? (r += parseInt(e.line_price), !1) : void 0
            }), r
        }), "undefined" == typeof shopstorm.apps.productCustomizer.itemPriceHelper && (shopstorm.apps.productCustomizer.itemPriceHelper = function (e, o) {
            var r = o.price;
            return o.properties && o.properties._pc_pricing_ref && o.properties._pc_pricing_qty && t.each(e, function (t, e) {
                return e.properties && "undefined" == typeof e.properties._pc_pricing_qty && e.properties._pc_pricing_ref == o.properties._pc_pricing_ref ? (r += parseInt(o.properties._pc_pricing_qty) * parseInt(e.price), !1) : void 0
            }), r
        }), "undefined" == typeof shopstorm.apps.productCustomizer.cartItemCountHelper && (shopstorm.apps.productCustomizer.cartItemCountHelper = function (e) {
            var o = e.item_count;
            return t.each(e.items, function (t, e) {
                e.properties && e.properties._pc_pricing_ref && "undefined" == typeof e.properties._pc_pricing_qty && (o -= parseInt(e.quantity))
            }), o
        }), "undefined" == typeof shopstorm.apps.productCustomizer.doSubmit && (shopstorm.apps.productCustomizer.doSubmit = function (e) {
            var e = t(document).find('form[action="/cart"');
            if (e.onsubmit) var o = e.onsubmit.call(e);
            o !== !1 && e.submit()
        }), "undefined" == typeof shopstorm.apps.productCustomizer.getWindowJQuery && (shopstorm.apps.productCustomizer.getWindowJQuery = function () {
            return window.jQuery || t
        }), "undefined" == typeof shopstorm.apps.productCustomizer.formatMoney && (shopstorm.apps.productCustomizer.formatMoney = function (t, e) {
            function o(t, e) {
                return "undefined" == typeof t ? e : t
            }

            function r(t, e, r, i) {
                if (e = o(e, 2), r = o(r, ","), i = o(i, "."), isNaN(t) || null == t) return 0;
                t = (t / 100).toFixed(e);
                var s = t.split("."),
                    n = s[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + r),
                    a = s[1] ? i + s[1] : "";
                return n + a
            }
            if ("undefined" != typeof Shopify.formatMoney) return Shopify.formatMoney(t, e);
            var i = "",
                s = /\{\{\s*(\w+)\s*\}\}/,
                n = e || "${{amount}}";
            switch ("string" == typeof t && (t = t.replace(".", "")), n.match(s)[1]) {
                case "amount":
                    i = r(t, 2);
                    break;
                case "amount_no_decimals":
                    i = r(t, 0);
                    break;
                case "amount_with_comma_separator":
                    i = r(t, 2, ".", ",");
                    break;
                case "amount_no_decimals_with_comma_separator":
                    i = r(t, 0, ".", ",")
            }
            return n.replace(s, i)
        });
        var r = t.grep(t("script"), function (t) {
            return t.innerHTML.match(/product-customizer-v\d+[0-9a-f-]*\.js/)
        });
        if (0 == r.length && t(".product-customizer-options, .product-customizer-customizations-total").remove(), "undefined" == typeof window.shopstorm.apps.productCustomizer.options || t.isArray(window.shopstorm.apps.productCustomizer.options)) {
            var s = {
                push: function (e) {
                    var o = e.id,
                        r = t('.product-customizer-options[data-product-id="' + o + '"]'),
                        i = e.data;
                    if (this.productOptions = this.productOptions || {}, this.productTitles = this.productTitles || {}, this.discount = e.discount || 0, !r.data("product-options-loaded") && (r.attr("data-product-options-loaded", !0), i = function (e) {
                        var o, r, i = [];
                        for (o in e) r = t.parseJSON(e[o]), r.fieldKey = o, i.push(r);
                        return i.sort(function (t, e) {
                            var o = "position";
                            return t.hasOwnProperty(o) || (o = "fieldKey"), t[o] < e[o] ? -1 : t[o] > e[o] ? 1 : 0
                        })
                    }(i), this.productOptions[o] = i, this.productTitles[o] = e.title, 0 != r.length)) {
                        t(".product-customizer-options input:file").on("change", function () {
                            var e, o, r, i, s;
                            e = t(this), r = e.attr("name"), i = e.val(), o = e.prev('[type="hidden"]'), r && i ? (0 == o.length && (s = r.replace("properties[", "properties[_"), o = t('<input type="hidden" name="' + s + '" />').insertBefore(e)), o.val(i.replace("C:\\fakepath\\", ""))) : o.remove()
                        });
                        var s = document.createElement("link");
                        s.rel = "stylesheet", s.type = "text/css", s.href = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css", document.getElementsByTagName("HEAD")[0].appendChild(s);
                        var n = document.createElement("script");
                        n.src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", n.onload = n.onreadystatechange = function () {
                            jQuery(".product-customizer-options input.pc_date").datepicker({
                                onSelect: function (t) {
                                    var e = new Date(t).toLocaleDateString();
                                    this.value = e
                                }
                            })
                        };
                        try {
                            document.body.appendChild(n)
                        } catch (a) {
                            try {
                                document.documentElement.childNodes[0].appendChild(n)
                            } catch (a) {
                                console.warn("Shopify Product Customizer: error loading jquery ui")
                            }
                        }
                        t(".product-customizer-options .option-type-checkbox_group").on("change", "input:checkbox", function () {
                            var e = t(this).closest(".option-type-checkbox_group"),
                                o = t.makeArray(e.find("input:checkbox:checked").map(function (e, o) {
                                    return t(o).val()
                                })).join(", ");
                            e.data("max-selections") && (e.find("input:checkbox:checked").length == e.data("max-selections") ? e.find("input:checkbox:not(:checked)").prop("disabled", !0).siblings("label").addClass("disabled") : e.find("input:checkbox:not(:checked)").prop("disabled", !1).siblings("label").removeClass("disabled")), e.find("input:hidden").val(o)
                        }), t(".product-customizer-options .option-type-select select[multiple]").on("change", function () {
                            var e = t(this).closest(".option-type-select"),
                                o = t(this).val().join(", "),
                                r = e.find("input:hidden");
                            0 == r.length && (r = t('<input type="hidden" name="' + t(this).attr("name") + '" value="" />').appendTo(e), t(this).attr("name", null)), r.val(o)
                        }), t(".rc_container input.rc_radio").on("change", t.proxy(function () {
                            this.showOptionsCost(o)
                        }, this)); {
                            r.closest('form[action="/cart/add"], form[action^="/cart/add?"]')
                        }
                        t.each(i, function (e) {
                            return function (i, s) {
                                var n, a, p;
                                a = s.fieldKey, p = i + 1, n = t(r.data("version") && shopstorm.apps.versionCompare(r.data("version"), "1.6.3", ">") ? "#" + o + "_option_" + p : "#" + o + "_option_" + a.split("_")[0]), (s.price || s.option_prices) && (n.closest(".option-type-checkbox_group, .option-type-radio").length > 0 && (n = n.closest(".option-type-checkbox_group, .option-type-radio").find("input:checkbox, input:radio")), shopstorm.apps.productCustomizer.pricingVariantId ? (n.on("change input", {
                                    productId: o
                                }, function (t) {
                                    return function (e) {
                                        t.showOptionsCost(e.data.productId)
                                    }
                                }(e)), r.attr("data-product-customizer-option-pricing", !0)) : console.warn("Shopify Product Customizer: dynamic pricing product variant id missing")), p++
                            }
                        }(this)), 1 == r.data("product-customizer-option-pricing") && this.showOptionsCost(o), this.setupAddToCartFormHandlers(o), this.initializeDeferredSetup()
                    }
                },
                initializeDeferredSetup: function () {
                    shopstorm.apps.productCustomizer.deferredSetupInitialized || (shopstorm.apps.productCustomizer.deferredSetupInitialized = !0, t(window).on("load", function (e) {
                        return function () {
                            t.each(e.productOptions, function (t) {
                                e.setupAddToCartFormHandlers(t)
                            })
                        }
                    }(this)), t(window.document).ready(function (e) {
                        return function () {
                            t.each(e.productOptions, function (t) {
                                e.setupAddToCartFormHandlers(t)
                            })
                        }
                    }(this)))
                },
                setupAddToCartFormHandlers: function (e) {
                    this.handleFileUploadFields(e), this.enforceRequiredFields(e), this.setupOptionPricing(e), t('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-add-to-cart-form-handlers-setup"), t != shopstorm.apps.productCustomizer.getWindowJQuery() && shopstorm.apps.productCustomizer.getWindowJQuery()('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-add-to-cart-form-handlers-setup")
                },
                handleFileUploadFields: function (e) {
                    var o = t('.product-customizer-options[data-product-id="' + e + '"]').closest('form[action="/cart/add"], form[action^="/cart/add?"]');
                    o.find("input:file").length > 0 && (o.attr("enctype", "multipart/form-data"), shopstorm.apps.productCustomizer.noHandleFileUploadFields || (o.addClass("noAJAX"), this.unbindProductFormHandlers(e)))
                },
                enforceRequiredFields: function (e, o) {
                    o = o || !1;
                    var r = t('.product-customizer-options[data-product-id="' + e + '"]').closest('form[action="/cart/add"], form[action^="/cart/add?"]');
                    if ((o || 0 != r.find("[name^=properties][required]").length || 0 != r.find(".option-type-checkbox_group[data-min-selections]").length) && (shopstorm.apps.productCustomizer.skipRequiredFieldsUnbind || this.unbindProductFormHandlers(e), o || !shopstorm.apps.productCustomizer.browserValidatesRequired() || 0 != r.find(".option-type-checkbox_group[data-min-selections]").length)) {
                        var i = this.getProductFormForEvents(e);
                        "undefined" != typeof i.on ? i.on("submit", {
                            productId: e
                        }, function () {
                            return shopstorm.apps.productCustomizer.formMarkMissingRequired(this) ? !1 : void 0
                        }) : i.bind("submit", {
                            productId: e
                        }, function () {
                            return shopstorm.apps.productCustomizer.formMarkMissingRequired(this) ? !1 : void 0
                        })
                    }
                },
                showOptionsCost: function (e) {
                    var o = shopstorm.apps.productCustomizer.sumOptionsCost(e),
                        r = t(".product-customizer-options[data-product-id=" + e + "]");
                    t('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-show-options-cost", o), t != shopstorm.apps.productCustomizer.getWindowJQuery() && shopstorm.apps.productCustomizer.getWindowJQuery()('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-show-options-cost", o);
                    var i = r.find(".customizations-total span");
                    0 == i.length && (i = t(".product-customizer-customizations-total[data-product-id=" + e + "] span")), i.length > 0 && i.html(shopstorm.apps.productCustomizer.formatMoney(o, shopstorm.shop.moneyFormat))
                },
                setupOptionPricing: function (e) {
                    var o = t('.product-customizer-options[data-product-id="' + e + '"]');
                    if (1 == o.data("product-customizer-option-pricing") && !shopstorm.apps.productCustomizer.noHandlePricingOptionsAddToCart) {
                        this.unbindProductFormHandlers(e), this.enforceRequiredFields(e);
                        var r = this.getProductFormForEvents(e);
                        "undefined" != typeof r.on ? r.on("submit", {
                            productId: e
                        }, function (t) {
                            return shopstorm.apps.productCustomizer.addOptionPricingItemToCart(t.data.productId)
                        }) : r.bind("submit", {
                            productId: e
                        }, function (t) {
                            return shopstorm.apps.productCustomizer.addOptionPricingItemToCart(t.data.productId)
                        })
                    }
                },
                manualAddOptions: function () {
                    var t = document.getElementsByClassName("product-customizer-options");
                    1 == t.length && shopstorm.apps.productCustomizer.addOptionPricingItemToCart(t[0].dataset.productId)
                },
                getProductFormForEvents: function (e, o) {
                    return o = o || shopstorm.apps.productCustomizer.getWindowJQuery(), -1 == t.inArray(o, window.shopstorm.apps.productCustomizer.jQueries) && window.shopstorm.apps.productCustomizer.jQueries.push(o), o('.product-customizer-options[data-product-id="' + e + '"]').closest("form")
                },
                unbindProductFormHandlers: function (e) {
                    this.getProductFormForEvents(e);
                    var o = this.getProductFormForEvents;
                    t.each(window.shopstorm.apps.productCustomizer.jQueries, function (t, r) {
                        $form = o(e, r), "undefined" != typeof $form.off ? ($form.off(), $form.find(shopstorm.apps.productCustomizer.productFormAddToCartSelector || ":submit").prop("onclick", null).off()) : ($form.unbind(), $form.find(shopstorm.apps.productCustomizer.productFormAddToCartSelector || ":submit").attr("onclick", "").unbind())
                    }), t('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-unbind-product-form-handlers"), t != shopstorm.apps.productCustomizer.getWindowJQuery() && shopstorm.apps.productCustomizer.getWindowJQuery()('.product-customizer-options[data-product-id="' + e + '"]').trigger("product-customizer-unbind-product-form-handlers")
                }
            };
            if ("undefined" == typeof window.shopstorm.apps.productCustomizer.options) window.shopstorm.apps.productCustomizer.options = s;
            else if (t.isArray(window.shopstorm.apps.productCustomizer.options)) {
                var n = window.shopstorm.apps.productCustomizer.options;
                window.shopstorm.apps.productCustomizer.options = s, t.each(n, function (t, e) {
                    s.push(e)
                })
            }
        }
        t.each(t('form[action="/cart"], form[action^="/cart?"]'), function (e, o) {
            var r = t(o);
            return r.data("product-options-initialized") ? !0 : (r.attr("data-product-options-initialized", !0), void t.each(r.find("[data-product-customizer-pricing-ref]:not([data-product-customizer-pricing-qty])"), function (e, o) {
                var i = t(o).data("product-customizer-pricing-ref"),
                    s = r.find("[data-product-customizer-pricing-ref=" + i + "][data-product-customizer-pricing-qty]");
                t.each(t(o).find("[data-prop-name]"), function (e, o) {
                    var r = s.find('[data-prop-name="' + t(o).data("prop-name").replace(/^_/, "") + '"]');
                    r.length > 0 && r.text() != t(o).text() && 0 == r.find(".option-amount").length && (match = t(o).text().trim().match(/\((\d+)\)$/)) && match[1] > 0 && r.html(r.html() + '<span class="option-amount">(+ ' + shopstorm.apps.productCustomizer.formatMoney(match[1], shopstorm.shop.moneyFormat) + ")</span>")
                })
            }))
        }), shopstorm.apps.productCustomizer.cartFormInitialized || (shopstorm.apps.productCustomizer.cartFormInitialized = !0, t(document).on("submit", 'form[action="/cart"], form[action^="/cart?"]', function () {
            t(this).prop("data-doing-submit", !0), shopstorm.apps.productCustomizer.updateCartPricingItemsQuantities(t(this))
        }), t(document).ajaxSend(function (e, o, r) {
            if ("/cart/change.js" == r.url) {
                var i, s, n = r.data.split("&");
                t.each(n, function (t, e) {
                    var o = e.split("=")[0];
                    "quantity" == o ? i = e.split("=")[1] : "line" == o && (s = e.split("=")[1])
                });
                var a = t(document).find("[data-line=" + s + "]").first();
                shopstorm.apps.productCustomizer.changeCartPricingItemQuantity(a, i)
            }
        }), shopstorm.apps.productCustomizer.bindCartRemove(['form[action="/cart"]', 'form[action^="/cart?"]'], function (t) {
            window.location.href = "/cart/change?line=" + t + "&quantity=0"
        })), shopstorm.apps.productCustomizer.triggeredProductCustomizerScriptLoaded || (shopstorm.apps.productCustomizer.triggeredProductCustomizerScriptLoaded = !0, t(document).trigger("product-customizer-script-loaded"), t != shopstorm.apps.productCustomizer.getWindowJQuery() && shopstorm.apps.productCustomizer.getWindowJQuery()(document).trigger("product-customizer-script-loaded"));
        var a = window.shopstorm.ConditionalLogic;
        a && a.init && t(a.init), shopstorm.apps.productCustomizer.swatchTriggered || (shopstorm.apps.productCustomizer.swatchTriggered = !0, t(".product-customizer-swatch__trigger").click(function (e) {
            t(".product-customizer-swatch-container.open").not(e.currentTarget.parentElement).toggleClass("open"), e.currentTarget.parentElement.classList.toggle("open"), e.stopPropagation()
        }), t(".product-customizer-swatch").click(function (e) {
            t(e.currentTarget).parent().find(".product-customizer-swatch.selected").toggleClass("selected"), e.currentTarget.parentElement.parentElement.classList.toggle("open"), e.currentTarget.classList.toggle("selected"), document.getElementById(e.currentTarget.dataset.id).value = e.currentTarget.dataset.value, e.currentTarget.parentElement.parentElement.querySelector(".product-customizer-selected-swatch").innerHTML = e.currentTarget.innerHTML, "function" == typeof window.productCustomizerCallbacks.swatchSelected && window.productCustomizerCallbacks.swatchSelected(e.currentTarget.dataset.id, e.currentTarget.dataset.value);
            var o = document.getElementsByClassName("product-customizer-options")[0].dataset.productId;
            window.shopstorm.apps.productCustomizer.options.showOptionsCost(o), e.stopPropagation()
        }), t(window).click(function () {
            t(".product-customizer-swatch-container.open").toggleClass("open")
        }), t(".custom_font_selector").fontselect().on("change", function (t) {
            if (console.log("You selected font: " + t), t.target.value.length > 0) {
                var e = t.target.value;
                e = e.replace(/\+/g, " "), e = e.split(":");
                var o = e[0],
                    r = e[1] || 400;
                jQuery("#" + t.target.dataset.target).css({
                    fontFamily: "'" + o + "'",
                    fontWeight: r
                }), "function" == typeof window.productCustomizerCallbacks.fontSelected && window.productCustomizerCallbacks.fontSelected(t.target.dataset.target, o)
            }
        }), t(".product-customizer-option input[type='file']").change(function () {
            if (input = this, input.files && input.files[0] && input.files[0].type.includes("image")) {
                var e = new FileReader;
                e.onload = function (e) {
                    var o = t("#" + input.id + "_preview");
                    if (0 == o.length) {
                        var o = t("<img />", {
                            id: input.id + "_preview",
                            src: e.target.result,
                            "class": "product-customizer-preview"
                        });
                        o.appendTo(t(input).parent())
                    } else o.attr("src", e.target.result);
                    "function" == typeof window.productCustomizerCallbacks.previewImage && window.productCustomizerCallbacks.previewImage(input.id, o)
                }, e.readAsDataURL(input.files[0])
            } else t("#" + input.id + "_preview").remove()
        })), "function" == typeof window.productCustomizerLoaded && window.productCustomizerCallbackLoaded()
    }),
    function () {
        var t;
        window.shopstorm || (window.shopstorm = {}), (t = window.shopstorm).ConditionalLogic || (t.ConditionalLogic = {})
    }.call(this),
    function () {
        var t, e;
        t = window.shopstorm.ConditionalLogic, e = function () {
            function e(e) {
                this.productOptionId = e, this.productOptionId && (this.$option = t.$(".product-customizer-option[data-product-option-id=" + this.productOptionId + "]"), this.$field = this.$option.find("input,select,textarea").filter('[name][type!="hidden"]'))
            }
            var o, r;
            return o = "conditional-logic-hidden", e.prototype.compareValue = function (e, o) {
                var r, i;
                return i = this.getValue(), r = null === i ? t.NullComparableValue : new t.ComparableValue(i), r[e](o)
            }, e.prototype.getValue = function () {
                var t;
                return this.$option.hasClass(o) ? null : (t = this.getOptionKind(), r(t).call(this))
            }, e.prototype.getOptionKind = function () {
                var t;
                return t = /option-type-(\S+)/.exec(this.$option.attr("class") || ""), t ? t[1] : ""
            }, e.prototype.show = function () {
                return this.$option.hasClass(o) ? (this.restoreFieldRequired(), this.restoreFieldName(), this.$option.show().removeClass(o), this.reTriggerHandlers(), !0) : !1
            }, e.prototype.hide = function () {
                return this.$option.hasClass(o) || 0 === this.$option.length ? !1 : (this.$option.hide().addClass(o), this.stashFieldName(), this.stashFieldRequired(), this.reTriggerHandlers(), !0)
            }, e.prototype.stashFieldName = function () {
                var t;
                return t = this.$field.attr("name"), t ? this.$field.data("name", t).attr("name", "") : void 0
            }, e.prototype.restoreFieldName = function () {
                var t;
                return t = this.$field.data("name"), t ? this.$field.attr("name", t).removeData("name") : void 0
            }, e.prototype.stashFieldRequired = function () {
                return this.$field.prop("required") ? this.$field.data("required", !0).prop("required", !1) : void 0
            }, e.prototype.restoreFieldRequired = function () {
                return this.$field.data("required") ? this.$field.prop("required", !0).removeData("required") : void 0
            }, e.prototype.reTriggerHandlers = function () {
                return this.$field.triggerHandler("change")
            }, r = function (t) {
                var e, o;
                return e = function () {
                    return (this.$field.val() || "").toLowerCase()
                }, o = {
                    checkbox: function () {
                        return this.$field.is(":checked") ? "checked" : ""
                    },
                    checkbox_group: function () {
                        return this.$option.find("input:checked").toArray().map(function (t) {
                            return t.value.toLowerCase()
                        })
                    },
                    file: function () {
                        return this.$field.val() ? "chosen" : ""
                    },
                    radio: function () {
                        return (this.$field.filter("input:checked").val() || "").toLowerCase()
                    }
                }, o[t] || e
            }, e
        }(), t.ComparableValue = function () {
            function t(t) {
                this.sourceValue = t
            }
            return t.prototype.is = function (t) {
                return Array.isArray(this.sourceValue) ? this.contains(t) : this.sourceValue === t
            }, t.prototype.isNot = function (t) {
                return !this.is(t)
            }, t.prototype.contains = function (t) {
                return -1 !== this.sourceValue.indexOf(t)
            }, t.prototype.startsWith = function (t) {
                return 0 === this.sourceValue.indexOf(t)
            }, t.prototype.endsWith = function (t) {
                var e;
                return e = this.sourceValue.length - t.length, 0 > e ? !1 : this.sourceValue.substring(e) === t
            }, t.prototype.greaterThan = function (t) {
                return /^[\d\.]+$/.test(t) ? +this.sourceValue > +t : this.sourceValue > t
            }, t.prototype.lessThan = function (t) {
                return /^[\d\.]+$/.test(t) ? +this.sourceValue < +t : this.sourceValue < t
            }, t
        }(), t.NullComparableValue = function () {
            var t;
            return t = function () {
                return !1
            }, {
                sourceValue: null,
                is: t,
                isNot: function () {
                    return !0
                },
                contains: t,
                startsWith: t,
                endsWith: t,
                greaterThan: t,
                lessThan: t
            }
        }(), t.OptionField = e
    }.call(this),
    function () {
        var t, e;
        e = window.shopstorm.ConditionalLogic.OptionField, t = function () {
            function t(t) {
                this.productOptionId = t.product_option_id, this.method = t.action_type, this.reversed = !1
            }
            var o;
            return t.prototype.execute = function () {
                var t;
                return t = new e(this.productOptionId), this.reversed = !1, t[this.method]()
            }, t.prototype.reverse = function () {
                var t, r;
                return t = new e(this.productOptionId), r = o[this.method], this.reversed = !0, t[r]()
            }, t.prototype.isEquivalentOf = function (t) {
                return ["productOptionId", "method", "reversed"].every(function (e) {
                    return function (o) {
                        return e[o] === t[o]
                    }
                }(this))
            }, o = {
                hide: "show",
                show: "hide"
            }, t
        }(), window.shopstorm.ConditionalLogic.Action = t
    }.call(this),
    function () {
        var t, e;
        e = window.shopstorm.ConditionalLogic.OptionField, t = function () {
            function t(t) {
                this.productOptionId = t.product_option_id, this.operator = t.operator, this.value = t.value.toLowerCase()
            }
            return t.prototype.evaluate = function () {
                var t;
                return t = new e(this.productOptionId), t.compareValue(this.operator, this.value)
            }, t
        }(), window.shopstorm.ConditionalLogic.Condition = t
    }.call(this),
    function () {
        var t, e, o;
        e = window.shopstorm.ConditionalLogic.Condition, t = window.shopstorm.ConditionalLogic.Action, o = function () {
            function o(t) {
                this.logicMatch = t.logic_match, this.conditions = t.conditions, this.actions = t.actions
            }
            var r;
            return o.prototype.evaluateConditions = function () {
                var t;
                if ("all" !== (t = this.logicMatch) && "any" !== t && "none" !== t) throw new Error("Conditional Logic unknown rule logicMatch '" + this.logicMatch + "'. Must be one of [all, any, none]");
                return o[this.logicMatch].call(this)
            }, o.prototype.run = function () {
                var e, o;
                return e = [], o = this.evaluateConditions(), this.actions.forEach(function (r) {
                    var i, s;
                    return i = new t(r), s = o ? i.execute() : i.reverse(), s ? e.push(i) : void 0
                }), e
            }, o.all = function () {
                return this.conditions.every(r)
            }, o.any = function () {
                return this.conditions.some(r)
            }, o.none = function () {
                return !this.conditions.some(r)
            }, r = function (t) {
                return new e(t).evaluate()
            }, o
        }(), window.shopstorm.ConditionalLogic.Rule = o
    }.call(this),
    function () {
        var t, e, o, r, i, s;
        t = window.shopstorm.ConditionalLogic, r = 0, t.runAll || (t.runAll = function () {
            var o, r;
            return o = [], r = t.rules || [], r.forEach(function (e) {
                var r, i;
                return i = new t.Rule(e), r = i.run(), o = o.concat(r)
            }), e(o) && s(r.length + 1) ? t.runAll() : i()
        }), t.init || (t.init = function (e) {
            return t.$ || (t.$ = e), t.$(".product-customizer-options").off("change", t.runAll).on("change", t.runAll), t.runAll()
        }), e = function (t) {
            var e, r, i, s, n;
            if (!t.length) return !1;
            e = o(t);
            for (s in e)
                if (n = e[s], r = n[0], i = n[n.length - 1], r.isEquivalentOf(i)) return !0;
            return !1
        }, o = function (t) {
            return t.reduce(function (t, e) {
                var o;
                return o = e.productOptionId, t[o] = (t[o] || []).concat(e), t
            }, {})
        }, s = function (t) {
            var e;
            return e = !(t % 2), e && t++, t > r ? (r++, !0) : (i(), console.warn("Product Customizer conditional logic detected looping rules - interrupting."), !1)
        }, i = function () {
            return r = 0
        }
    }.call(this);