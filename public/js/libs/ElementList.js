class ElementList {
  constructor() {
    this.list = [];
  }

  get(){
    return this.list
  }

  hasElements(){
    return this.list.length>0
  }

  inParent(parent) {
    if (typeof parent == "string") parent = document.querySelector(parent);
    else if (parent instanceof ElementEv) parent = parent.get();

    this.parentSearch = parent;

    return this;
  }

  whereClass(clss, cb) {
    let elements = [];

    if (this.parentSearch)
      elements = this.parentSearch.querySelectorAll("." + clss);
    else elements = document.querySelectorAll("." + clss);

    for (let element of elements) {
      this.list.push(new ElementEv(element, true));
    }

    return this;
  }

  whereId(id, cb) {
    let elements = [];

    if (this.parentSearch)
      elements = this.parentSearch.querySelectorAll("#" + id);
    else elements = document.querySelectorAll("#" + id);

    for (let element of elements) {
      this.list.push(new ElementEv(element, true));
    }

    return this;
  }

  whereTag(tag, cb) {
    let elements = [];

    if (this.parentSearch) elements = this.parentSearch.querySelectorAll(tag);
    else elements = document.querySelectorAll(tag);

    for (let element of elements) {
      this.list.push(new ElementEv(element, true));
    }

    return this;
  }

  whereProp(values, cb) {
    let elements = [];

    if (this.parentSearch)
      elements = this.parentSearch.querySelectorAll(
        `[${values[0]}=${values[1]}]`
      );
    else elements = document.querySelectorAll(`[${values[0]}=${values[1]}]`);

    for (let element of elements) {
      this.list.push(new ElementEv(element, true));
    }

    return this;
  }

  event(ev, cb) {
    this.list.forEach(function (elementEv) {
      elementEv.element.addEventListener(ev, function (event) {
        event.element = elementEv;

        cb(event);
      });
    });

    return this;
  }

  print() {
    let elementsToShow = [];

    this.list.forEach(function (e) {
      elementsToShow.push(e.element.outerHTML);
    });

    console.log(elementsToShow);

    return this;
  }

  values(type) {
    let values = [];

    if (type == "checkbox") {
      this.list.forEach(function (elementEvCheckbox) {
        if (elementEvCheckbox.get().checked)
          values.push(elementEvCheckbox.element.value);
      });

      return values;
    }
  }
}

function elements() {
  return new ElementList();
}
