/* PushMenu()
 * ==========
 * Adds the push menu functionality to the sidebar.
 *
 * @usage: $('.btn').pushMenu(options)
 *          or add [data-toggle="push-menu"] to any button
 *          Pass any option as data-option="value"
 */
(function ($) {
    "use strict";

    let DataKey = "lte.pushmenu";
    const pushmenuStateLocalKey = "pushmenuStateLocalKey";

    let Default = {
        collapseScreenSize: 767,
        expandOnHover: false,
        expandTransitionDelay: 200
    };

    let Selector = {
        collapsed: ".sidebar-collapse",
        open: ".sidebar-open",
        mainSidebar: ".main-sidebar",
        contentWrapper: ".Content-wrapper",
        searchInput: ".sidebar-form .form-control",
        button: '[data-toggle="push-menu"]',
        mini: ".sidebar-mini",
        expanded: ".sidebar-expanded-on-hover",
        layoutFixed: ".fixed"
    };

    let ClassName = {
        collapsed: "sidebar-collapse",
        open: "sidebar-open",
        mini: "sidebar-mini",
        expanded: "sidebar-expanded-on-hover",
        expandFeature: "sidebar-mini-expand-feature",
        layoutFixed: "fixed"
    };

    let Event = {
        expanded: "expanded.pushMenu",
        collapsed: "collapsed.pushMenu"
    };

    // PushMenu Class Definition
    // =========================
    let PushMenu = function (options) {
        this.options = options;
        this.init();
    };

    PushMenu.prototype.init = function () {
        if (this.options.expandOnHover || ($("body").is(Selector.mini + Selector.layoutFixed))) {
            this.expandOnHover();
            $("body").addClass(ClassName.expandFeature);
        }

        $(Selector.contentWrapper).click(function () {
            // Enable hide menu when clicking on the Content-wrapper on small screens
            if ($(window).width() <= this.options.collapseScreenSize && $("body").hasClass(ClassName.open)) {
                this.close();
            }
        }.bind(this));

        // __Fix for android devices
        $(Selector.searchInput).click(function (e) {
            e.stopPropagation();
        });
    };

    PushMenu.prototype.toggle = function () {
        let windowWidth = $(window).width();
        let isOpen = !$("body").hasClass(ClassName.collapsed);

        if (windowWidth <= this.options.collapseScreenSize) {
            isOpen = $("body").hasClass(ClassName.open);
        }

        if (!isOpen) {
            this.open();
        } else {
            this.close();
        }
    };

    PushMenu.prototype.open = function () {
        let windowWidth = $(window).width();

        if (windowWidth > this.options.collapseScreenSize) {
            $("body").removeClass(ClassName.collapsed)
                .trigger($.Event(Event.expanded));
        } else {
            $("body").addClass(ClassName.open)
                .trigger($.Event(Event.expanded));
        }
        localStorage.setItem(pushmenuStateLocalKey, true);
    };

    PushMenu.prototype.close = function () {
        let windowWidth = $(window).width();
        if (windowWidth > this.options.collapseScreenSize) {
            $("body").addClass(ClassName.collapsed)
                .trigger($.Event(Event.collapsed));
        } else {
            $("body").removeClass(ClassName.open + " " + ClassName.collapsed)
                .trigger($.Event(Event.collapsed));
        }

        localStorage.setItem(pushmenuStateLocalKey, false);
    };

    PushMenu.prototype.expandOnHover = function () {
        $(Selector.mainSidebar).hover(function () {
                if ($("body").is(Selector.mini + Selector.collapsed) &&
                    $(window).width() > this.options.collapseScreenSize) {
                    this.expand();
                }
            }.bind(this),
            function () {
                if ($("body").is(Selector.expanded)) {
                    this.collapse();
                }
            }.bind(this));
    };

    PushMenu.prototype.expand = function () {
        setTimeout(function () {
                $("body").removeClass(ClassName.collapsed)
                    .addClass(ClassName.expanded);
            },
            this.options.expandTransitionDelay);
    };

    PushMenu.prototype.collapse = function () {
        setTimeout(function () {
                $("body").removeClass(ClassName.expanded)
                    .addClass(ClassName.collapsed);
            },
            this.options.expandTransitionDelay);
    };

    // PushMenu Plugin Definition
    // ==========================
    function Plugin(option) {
        return this.each(function () {
            let $this = $(this);
            let data = $this.data(DataKey);

            if (!data) {
                let options = $.extend({}, Default, $this.data(), typeof option == "object" && option);
                $this.data(DataKey, (data = new PushMenu(options)));
            }

            if (option == "toggle") {
                data.toggle();
            } else {
                if(Math.max(document.documentElement.clientWidth, window.innerWidth || 0) > 680){
                    //getting from local storage
                    let isOpen = localStorage.getItem(pushmenuStateLocalKey) == null || localStorage.getItem(pushmenuStateLocalKey) == "true";
                    if (isOpen) {
                        data.open();
                    }
                    else {
                        data.close();
                    }
                }
            }
        });
    }

    let old = $.fn.pushMenu;

    $.fn.pushMenu = Plugin;
    $.fn.pushMenu.Constructor = PushMenu;

    // No Conflict Mode
    // ================
    $.fn.pushMenu.noConflict = function () {
        $.fn.pushMenu = old;
        return this;
    };

    // Data API
    // ========
    $(document).on("click",
        Selector.button,
        function (e) {
            e.preventDefault();
            Plugin.call($(this), "toggle");
        });
    $(window).on("load",
        function () {
            Plugin.call($(Selector.button));
        });
}(window.jQuery));

/* Tree()
 * ======
 * Converts a nested list into a multilevel
 * tree view menu.
 *
 * @Usage: $('.my-menu').tree(options)
 *         or add [data-widget="tree"] to the ul element
 *         Pass any option as data-option="value"
 */
(function ($) {
    "use strict";

    let DataKey = "lte.tree";

    let Default = {
        animationSpeed: 500,
        accordion: true,
        followLink: false,
        trigger: ".treeview a"
    };

    let Selector = {
        tree: ".tree",
        treeview: ".treeview",
        treeviewMenu: ".treeview-menu",
        open: ".menu-open, .active",
        li: "li",
        data: '[data-widget="tree"]',
        active: ".active"
    };

    let ClassName = {
        open: "menu-open",
        tree: "tree"
    };

    let Event = {
        collapsed: "collapsed.tree",
        expanded: "expanded.tree"
    };

    // Tree Class Definition
    // =====================
    let Tree = function (element, options) {
        this.element = element;
        this.options = options;

        $(this.element).addClass(ClassName.tree);

        $(Selector.treeview + Selector.active, this.element).addClass(ClassName.open);

        this.selectCurrentPage();
        this._setUpListeners();
        this.setupSlimScroll();
    };

    Tree.prototype.toggle = function (link, event) {
        let treeviewMenu = link.next(Selector.treeviewMenu);
        let parentLi = link.parent();
        let isOpen = parentLi.hasClass(ClassName.open);

        if (!parentLi.is(Selector.treeview)) {
            return;
        }

        if (!this.options.followLink || link.attr("href") == "#") {
            event.preventDefault();
        }

        if (isOpen) {
            this.collapse(treeviewMenu, parentLi);
        } else {
            this.expand(treeviewMenu, parentLi);
        }
    };

    Tree.prototype.expand = function (tree, parent) {
        let expandedEvent = $.Event(Event.expanded);

        if (this.options.accordion) {
            let openMenuLi = parent.siblings(Selector.open);
            let openTree = openMenuLi.children(Selector.treeviewMenu);
            this.collapse(openTree, openMenuLi);
        }

        parent.addClass(ClassName.open);
        tree.slideDown(this.options.animationSpeed,
            function () {
                $(this.element).trigger(expandedEvent);
            }.bind(this));
    };

    Tree.prototype.collapse = function (tree, parentLi) {
        let collapsedEvent = $.Event(Event.collapsed);

        tree.find(Selector.open).removeClass(ClassName.open);
        parentLi.removeClass(ClassName.open);
        tree.slideUp(this.options.animationSpeed,
            function () {
                tree.find(Selector.open + " > " + Selector.treeview).slideUp();
                $(this.element).trigger(collapsedEvent);
            }.bind(this));
    };

    // Private

    Tree.prototype._setUpListeners = function () {
        let that = this;

        $(this.element).on("click",
            this.options.trigger,
            function (event) {
                that.toggle($(this), event);
            });
    };

    Tree.prototype.setupSlimScroll = function () {
        $('.sidebar-scroll-container').slimscroll({
            height: 'auto'
        });
    };

    Tree.prototype.selectCurrentPage = function () {
        let currentUrl = window.location.pathname;
        $(".sidebar li>a[href$='" + currentUrl + "']")
            .parent("li").addClass("active")
            .parent("ul.treeview-menu").css("display", "block")
            .parent(".treeview").addClass("active");
    };

    // Plugin Definition
    // =================
    function Plugin(option) {
        return this.each(function () {
            let $this = $(this);
            let data = $this.data(DataKey);

            if (!data) {
                let options = $.extend({}, Default, $this.data(), typeof option == "object" && option);
                $this.data(DataKey, new Tree($this, options));
            }
        });
    }

    let old = $.fn.tree;

    $.fn.tree = Plugin;
    $.fn.tree.Constructor = Tree;

    // No Conflict Mode
    // ================
    $.fn.tree.noConflict = function () {
        $.fn.tree = old;
        return this;
    };

    // Tree Data API
    // =============
    $(window).on("load",
        function () {
            $(Selector.data).each(function () {
                Plugin.call($(this));
            });
        });
}(window.jQuery));


/* Common page functions()
 * ==========
 * common page functionalities
 *
 */
(function ($) {
    "use strict";

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
}(window.jQuery));