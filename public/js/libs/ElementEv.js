class ElementEv {
    constructor(tag, exists) {
        if (exists) {
            this.element = tag;
        } else if (tag) {
            this.element = document.createElement(tag);
        } else {
            this.element = null;
        }

        this.lastEventSetted = null;
        this.events = {};

        this.prevSib = null;
        this.nextSib = null;

        this.lastElementCreated = null;
        this.fragment = document.createDocumentFragment();

        this.interceptObject = null;
    }

    create(tag) {
        this.element = document.createElement(tag);
        return this;
    }

    // SEARCHING

    inParent(parent) {
        if (typeof parent == "string") parent = document.querySelector(parent);
        else if (parent instanceof ElementEv) parent = parent.get();
        this.parentSearch = parent;
        return this;
    }

    whereClass(clss, cb) {
        if (clss instanceof Array) {
            clss = __ElementEv__multiFilterConcat__(clss, ".");
        }
        if (this.parentSearch)
            this.element = this.parentSearch.querySelector("." + clss);
        else this.element = document.querySelector("." + clss);

        if (cb && !this.element) {
            this.element = cb();
        }
        this.parentSearch = null;
        return this;
    }

    whereId(id, cb) {
        if (id instanceof Array) {
            id = __ElementEv__multiFilterConcat__(clss, "#");
        }
        if (this.parentSearch)
            this.element = this.parentSearch.querySelector("#" + id);
        else this.element = document.querySelector("#" + id);

        if (cb && !this.element) {
            this.element = cb();
        }
        this.parentSearch = null;
        return this;
    }

    whereTag(tag, cb) {
        if (tag instanceof Array) {
            tag = __ElementEv__multiFilterConcat__(clss, "");
        }
        if (this.parentSearch)
            this.element = this.parentSearch.querySelector(tag);
        else this.element = document.querySelector(tag);

        if (cb && !this.element) {
            this.element = cb();
        }
        this.parentSearch = null;
        return this;
    }

    whereProp(values, cb) {
        if (this.parentSearch)
            this.element = this.parentSearch.querySelector(
                `[${values[0]}=${values[1]}]`
            );
        else
            this.element = document.querySelector(
                `[${values[0]}=${values[1]}]`
            );

        if (cb && !this.element) {
            this.element = cb();
        }

        this.parentSearch = null;
        return this;
    }

    // EVENTS

    when(ev, cb) {
        this.lastEventSetted = ev;
        if (cb) this.make(cb);
        return this;
    }

    make(cb) {
        this.events[this.lastEventSetted] = function (e) {
            e.element = el;
            cb(e);
        };
        let el = this;
        this.element.addEventListener(
            this.lastEventSetted,
            this.events[this.lastEventSetted]
        );
        return this;
    }

    unsetEvent(ev) {
        this.element.removeEventListener(ev, this.events[ev]);
        return this;
    }

    interception(cb, obj) {
        var r, margin, th, cb2;

        if (!obj) obj = {};

        if (!obj.whilenot) cb2 = false;
        else cb2 = true;

        r = obj.root || document;

        if (typeof r == "string") r = document.querySelector(r);

        if (!obj.delay) margin = "0px";
        else margin = `${obj.delay * 1.5}px 0px -${obj.delay * 1.5}px 0px`;

        th = obj.th || 0.5;

        this.interceptObject = new IntersectionObserver(
            function (ent) {
                ent.forEach((e) => {
                    if (e.isIntersecting) cb();
                    else {
                        if (cb2) obj.whilenot();
                    }
                });
            },
            { root: r, rootMargin: margin, threshold: th }
        );

        this.interceptObject.observe(this.element);

        return this;
    }

    endInterception() {
        this.interceptObject.unobserve(this.element);

        return this;
    }

    // CONTENT

    setText(c) {
        this.element.textContent = c;

        return this;
    }

    textIs(str) {
        return this.element.textContent == str;
    }

    clear() {
        this.element.innerHTML = "";

        return this;
    }

    // CHILDS and parents

    createChild(tag, text) {
        tag = tag.replace(">", ""); //for <
        tag = tag.replace("<", "");
        if (!this.fragment) {
            this.fragment = document.createDocumentFragment();
        }
        if (this.lastElementCreated) {
            this.fragment.appendChild(this.lastElementCreated.element);
        }
        if (tag instanceof ElementEv) {
            this.lastElementCreated = tag;
        } else {
            this.lastElementCreated = new ElementEv(tag);
        }
        if (text) this.lastElementCreated.setText(text);
        return this;
    }

    withText(c) {
        this.lastElementCreated.setText(c);

        return this;
    }

    insert() {
        if (this.lastElementCreated) {
            this.fragment.appendChild(this.lastElementCreated.element);

            this.lastElementCreated = null;
        }

        this.element.appendChild(this.fragment);

        this.fragment = null;

        return this;
    }

    appendChild(child) {
        //  console.log('insert');

        this.element.appendChild(child.get());

        return this;
    }

    withChildren(nodes) {
        if (nodes instanceof Array) {
            const thisCopy = this;

            nodes.forEach(function (element) {
                thisCopy.fragment.appendChild(element.get());
            });

            thisCopy.element.appendChild(this.fragment);

            this.fragment = null;

            return thisCopy;
        }

        this.insert(nodes);

        return this;
    }

    lastChild() {
        return new ElementEv(
            this.element.children[this.element.children.length - 1],
            true
        );
    }

    firstChild() {
        return new ElementEv(this.element.children[0], true);
    }

    parent(deep) {
        if (!deep) return new ElementEv(this.element.parentElement, true);

        let parent = this.element.parentElement;

        for (var i = 1; i < deep; i++) {
            parent = parent.parentElement;
        }

        return new ElementEv(parent, true);
    }

    hasNextSibling() {
        if (this.get().nextSibling) return true;
        else return false;
    }

    hasPrevSibling() {
        if (this.get().prevSibling) return true;
        else return false;
    }

    prevSibling(deep) {
        if (!deep) return new ElementEv(this.element.previousSibling, true);

        let sib = this.element.previousSibling;

        for (var i = 1; i < deep; i++) {
            sib = sib.previousSibling;
        }

        return new ElementEv(sib, true);
    }

    nextSibling(deep) {
        if (!deep) return new ElementEv(this.element.nextSibling, true);

        let sib = this.element.nextSibling;

        for (var i = 1; i < deep; i++) {
            sib = sib.nextSibling;
        }

        return new ElementEv(sib, true);
    }

    // ELEMENT

    get() {
        return this.element;
    }

    value() {
        let field = this.element;

        if (field.type === "checkbox") {
            return field.checked ? field.value : null;
        } else if (field.type === "radio") {
            return field.checked ? field.value : null;
        } else {
            return field.value;
        }
    }

    valueIs(val) {
        return this.element.value == val;
    }

    tagIs(tag) {
        return this.element.tagName == tag.toUpperCase();
    }

    remove() {
        this.element.parentElement.removeChild(this.element);

        return this;
    }

    move(to) {
        let el = this.get();

        this.remove();

        to.element.appendChild(el);

        return this;
    }

    removeAfter(ms, cb) {
        let el = this;
        setTimeout(function () {
            el.remove();
            if (cb) cb();
        }, ms);
        return this;
    }

    toggleAfter(ms, clss) {
        let el = this;

        let timer = setTimeout(function () {
            el.element.classList.toggle(clss);
        }, ms);

        return this;
    }

    // CLASSES AND PROPS

    hasClass(clss) {
        return this.element.classList.contains(clss);
    }

    addClass(c) {
        this.element.classList.add(c);

        return this;
    }

    removeClass(c) {
        this.element.classList.remove(c);

        return this;
    }

    toggleClass(c) {
        this.element.classList.toggle(c);
        return this;
    }

    withAttrs(pairs) {
        let copy = this;
        if (this.lastElementCreated) {
            Object.entries(pairs).forEach(function (pair) {
                copy.lastElementCreated.attr(pair[0], pair[1]);
            });
        } else {
            Object.entries(pairs).forEach(function (pair) {
                copy.element.attr(pair[0], pair[1]);
            });
        }

        return copy;
    }

    prop(name) {
        return this.element[name];
    }

    attr(key, value) {
        if (!value) return this.element.getAttribute(key);
        else this.element.setAttribute(key, value);

        return this;
    }

    attrIs(key, value) {
        return this.element.getAttribute(key) == value;
    }

    position() {
        let rect = this.element.getBoundingClientRect();

        return {
            top: rect.top,
            right: rect.right,
            bottom: rect.bottom,
            left: rect.left,
        };
    }

    propToggle(key, v1, v2) {
        if (this.attrIs(key, v1)) {
            this.attr(key, v2);
        } else {
            this.attr(key, v1);
        }

        return this;
    }

    // Others

    print() {
        console.log(this.element.outerHTML);
        return this;
    }

    style(css) {
        var el = this.element;

        Object.entries(css).forEach(function (p) {
            el.style[p[0]] = p[1];
        });

        //this.element = el

        return this;
    }

    hide() {
        this.element.style.display = "none";
        return this;
    }

    show(val) {
        if (!val) val = "block";
        this.element.style.display = val;
        return this;
    }

    visible(opacity) {
        this.element.style.opacity = opacity;

        return this;
    }

}

function element(tag) {
    if (tag instanceof HTMLElement) {
        return new ElementEv(tag, true);
    }
    return new ElementEv(tag);
}

function create(tag, content) {
    tag = tag.replace(">", ""); //for <
    tag = tag.replace("<", "");

    element = new ElementEv(tag);

    if (content) element.setContent(content);

    return element;
}

// privates

function __ElementEv__multiFilterConcat__(list, prefix) {
    let multi = "";

    for (let id of list) {
        multi += id + "," + prefix;
    }

    return multi.substr(0, multi.length - 2);
}

function _find(query) {
    return new ElementEv(document.querySelector(query), true);
}
