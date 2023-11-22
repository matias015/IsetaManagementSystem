function ElementEv (tag, exists){

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

ElementEv.GLOBAL_PARENT = null;


ElementEv.SetGlobalParent=function(query){
    ElementEv.GLOBAL_PARENT = document.querySelector(query);
}

ElementEv.prototype.create = function(tag) {
    this.element = document.createElement(tag);
    return this;
}

// SEARCHING

ElementEv.prototype.inParent = function(parent) {
    if (typeof parent == "string") parent = document.querySelector(parent);
    else if (parent instanceof ElementEv) parent = parent.get();
    this.parentSearch = parent;
    return this;
}

ElementEv.prototype.whereClass=function(clss, cb) {
    if (this.parentSearch)
        this.element = this.parentSearch.querySelector("." + clss);
    else if (ElementEv.GLOBAL_PARENT)
        this.element = ElementEv.GLOBAL_PARENT.querySelector("." + clss);
    else this.element = document.body.querySelector(clss);

    if (cb && !this.element) {
        this.element = cb();
    }
    this.parentSearch = null;
    return this;
}

ElementEv.prototype.whereId = function(id, cb) {
    if (this.parentSearch)
        this.element = this.parentSearch.querySelector("#" + id);
    else if (ElementEv.GLOBAL_PARENT){
        this.element = ElementEv.GLOBAL_PARENT.querySelector("#" + id);
    }
    else this.element = document.getElementById(id);

    if (cb && !this.element) {
        this.element = cb();
    }
    this.parentSearch = null;
    return this;
}

ElementEv.prototype.whereTag=function(tag, cb) {
    if (this.parentSearch) this.element = this.parentSearch.querySelector(tag);
    else if (ElementEv.GLOBAL_PARENT){
        this.element = ElementEv.GLOBAL_PARENT.querySelector(tag);
    }
    else this.element = document.body.querySelector(tag);
    console.log(cb);
    console.log(this.element);
    if (cb && !this.element) {
        
        this.element = cb();
    }
    this.parentSearch = null;
    return this;
}

ElementEv.prototype.whereProp = function(values, cb) {
    if (this.parentSearch)
        this.element = this.parentSearch.querySelector(
            `[${values[0]}=${values[1]}]`
        );
    else if (ElementEv.GLOBAL_PARENT){
        this.element = ElementEv.GLOBAL_PARENT.querySelector(
            `[${values[0]}=${values[1]}]`
        );
    }
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

// // EVENTS

ElementEv.prototype.when = function(ev, cb) {
    this.lastEventSetted = ev;
    if (cb) this.make(cb);
    return this;
}

ElementEv.prototype.make=function(cb) {
    let el = this;
    this.events[this.lastEventSetted] = function (e) {
        e.element = el;
        cb(e);
    };
    this.element.addEventListener(
        this.lastEventSetted,
        this.events[this.lastEventSetted]
    );
    return this;
}

ElementEv.prototype.unsetEvent = function(ev) {
    this.element.removeEventListener(ev, this.events[ev]);
    return this;
}

ElementEv.prototype.interception = function(cb, obj) {
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

ElementEv.prototype.endInterception = function() {
    this.interceptObject.unobserve(this.element);

    return this;
}

// CONTENT

ElementEv.prototype.setText=function(c) {
    this.element.textContent = c;
    return this;
}

ElementEv.prototype.textIs =function(str) {
    return this.element.textContent == str;
}

ElementEv.prototype.clear = function() {
    this.element.innerHTML = "";

    return this;
}

// CHILDS and parents

ElementEv.prototype.createChild = function(tag, text) {
    tag = tag.replace(">", ""); //for <
    tag = tag.replace("<", "");
    if (!this.fragment) {
        this.fragment = document.createDocumentFragment();
    }
    if (this.lastElementCreated) {
        this.fragment.appendChild(this.lastElementCreated);
    }
    if (tag instanceof ElementEv) {
        this.lastElementCreated = tag;
    } else {
        this.lastElementCreated = document.createElement(tag);
    }
    if (text) this.lastElementCreated.textContent = text;
    return this;
}


ElementEv.prototype.insert = function() {
    if (this.lastElementCreated) {
        this.fragment.appendChild(this.lastElementCreated);
        this.lastElementCreated = null;
    }
    this.element.appendChild(this.fragment);
    this.fragment = null;
    return this;
}

ElementEv.prototype.insertInto = function(parent){
    if(typeof parent == 'string') parent = document.querySelector(parent)
    if(parent instanceof ElementEv) parent = parent.get()
    parent.appendChild(this.get())
    return this
}

ElementEv.prototype.withText = function(c) {
    
    this.lastElementCreated.textContent = c;

    return this;
}

ElementEv.prototype.withClasses = function(list){
    if(!(list instanceof Array)) this.lastElementCreated.classList.add(list)
    else{
        for(let c of list){
            this.lastElementCreated.classList.add(c)
        }
    }   
    return this
}


ElementEv.prototype.withChildren = function(nodes) {
    if (nodes instanceof Array) {
        const thisCopy = this;

        nodes.forEach(function (element) {

            thisCopy.lastElementCreated.appendChild(element.get());
        });
        ;
        return thisCopy;
    } 
    this.lastElementCreated.appendChild(nodes);
    
    return this;
}


ElementEv.prototype.withAttrs = function(pairs) {
    let copy = this;
    Object.entries(pairs).forEach(function (pair) {
        copy.lastElementCreated.setAttribute(pair[0], pair[1]);
    });

    return copy;
}

ElementEv.prototype.appendChild = function(child) {
    this.element.appendChild(child.get());
    return this;
}

ElementEv.prototype.lastChild = function() {
    return new ElementEv(
        this.element.children[this.element.children.length - 1],
        true
    );
}

ElementEv.prototype.firstChild = function() {
    return new ElementEv(this.element.children[0], true);
}

ElementEv.prototype.parent = function(deep) {
    if (!deep) return new ElementEv(this.element.parentElement, true);

    let parent = this.element.parentElement;

    for (var i = 1; i < deep; i++) {
        parent = parent.parentElement;
    }

    return new ElementEv(parent, true);
}

ElementEv.prototype.hasNextSibling = function() {
    if (this.get().nextSibling) return true;
    else return false;
}

ElementEv.prototype.hasPrevSibling = function() {
    if (this.get().prevSibling) return true;
    else return false;
}

ElementEv.prototype.prevSibling = function(deep) {
    if (!deep) return new ElementEv(this.element.previousSibling, true);

    let sib = this.element.previousSibling;

    for (var i = 1; i < deep; i++) {
        sib = sib.previousSibling;
    }

    return new ElementEv(sib, true);
}

ElementEv.prototype.nextSibling = function(deep) {
    if (!deep) return new ElementEv(this.element.nextSibling, true);

    let sib = this.element.nextSibling;

    for (var i = 1; i < deep; i++) {
        sib = sib.nextSibling;
    }

    return new ElementEv(sib, true);
}

// ELEMENT

ElementEv.prototype.get = function() {
    return this.element;
}

ElementEv.prototype.value = function() {
    let field = this.element;

    if (field.type === "checkbox") {
        return field.checked ? field.value : null;
    } else if (field.type === "radio") {
        return field.checked ? field.value : null;
    } else {
        return field.value;
    }
}

ElementEv.prototype.valueIs = function(val) {
    return this.element.value == val;
}

ElementEv.prototype.tagIs = function(tag) {
    return this.element.tagName == tag.toUpperCase();
}

ElementEv.prototype.remove = function() {
    this.element.parentElement.removeChild(this.element);

    return this;
}

ElementEv.prototype.move = function(to) {
    let el = this.get();

    this.remove();

    to.element.appendChild(el);

    return this;
}

ElementEv.prototype.removeAfter = function(ms, cb) {
    let el = this;
    setTimeout(function () {
        el.remove();
        if (cb) cb();
    }, ms);
    return this;
}

ElementEv.prototype.toggleAfter = function(ms, clss) {
    let el = this;

    let timer = setTimeout(function () {
        el.element.classList.toggle(clss);
    }, ms);

    return this;
}

// CLASSES AND PROPS

ElementEv.prototype.hasClass = function(clss) {
    return this.element.classList.contains(clss);
}

ElementEv.prototype.addClass = function(c) {
    this.element.classList.add(c);

    return this;
}

ElementEv.prototype.removeClass = function(c) {
    this.element.classList.remove(c);

    return this;
}

ElementEv.prototype.toggleClass = function(c) {
    this.element.classList.toggle(c);
    return this;
}


ElementEv.prototype.prop = function(name) {
    return this.element[name];
}

ElementEv.prototype.attr = function(key, value) {
    if (!value) return this.element.getAttribute(key);
    else this.element.setAttribute(key, value);

    return this;
}

ElementEv.prototype.setAttrs = function(key, value) {
    let copy = this;
    Object.entries(pairs).forEach(function (pair) {
        copy.element.setAttribute(pair[0], pair[1]);
    });

    return copy;
}

ElementEv.prototype.attrIs = function(key, value) {
    return this.element.getAttribute(key) == value;
}

ElementEv.prototype.position = function() {
    let rect = this.element.getBoundingClientRect();

    return {
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        left: rect.left,
    };
}

ElementEv.prototype.propToggle = function(key, v1, v2) {
    if (this.attrIs(key, v1)) {
        this.attr(key, v2);
    } else {
        this.attr(key, v1);
    }

    return this;
}

// Others

ElementEv.prototype.print = function() {
    console.log(this.element.outerHTML);
    return this;
}

ElementEv.prototype.style = function(css) {
    var el = this.element;

    Object.entries(css).forEach(function (p) {
        el.style[p[0]] = p[1];
    });

    //this.element = el

    return this;
}

ElementEv.prototype.withStyle = function(css) {
    var el = this;

    Object.entries(css).forEach(function (p) {
        el.lastElementCreated.style[p[0]] = p[1];
    });

    //this.element = el

    return this;
}

ElementEv.prototype.hide = function() {
    this.element.style.display = "none";
    return this;
}

ElementEv.prototype.show=function(val) {
    if (!val) val = "block";
    this.element.style.display = val;
    return this;
}

ElementEv.prototype.visible = function(opacity) {
    this.element.style.opacity = opacity;

    return this;
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

    if (content) element.setText(content);

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
