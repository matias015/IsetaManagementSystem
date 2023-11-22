function ElementList() {

  this.list = [];
}

ElementList.GLOBAL_PARENT = null;


ElementList.SetGlobalParent=function(query){
  ElementList.GLOBAL_PARENT = document.querySelector(query);
}

ElementList.prototype.get = function(){
  return this.list
}

ElementList.prototype.hasElements = function(){
  return this.list.length>0
}

ElementList.prototype.inParent = function(parent) {
  if (typeof parent == "string") parent = document.querySelector(parent);
  else if (parent instanceof ElementEv) parent = parent.get();

  this.parentSearch = parent;

  return this;
}

ElementList.prototype.whereClass = function(clss, cb) {
  let elements = [];

  if (this.parentSearch)
    elements = this.parentSearch.querySelectorAll("." + clss);
  else elements = document.querySelectorAll("." + clss);

  for (let element of elements) {
    this.list.push(new ElementEv(element, true));
  }

  return this;
}

ElementList.prototype.whereId = function(id, cb) {
  let elements = [];

  if (this.parentSearch)
    elements = this.parentSearch.querySelectorAll("#" + id);
  else elements = document.querySelectorAll("#" + id);

  for (let element of elements) {
    this.list.push(new ElementEv(element, true));
  }

  return this;
}

ElementList.prototype.whereTag = function(tag, cb) {
  let elements = [];

  if (this.parentSearch) elements = this.parentSearch.querySelectorAll(tag);
  else if (ElementList.GLOBAL_PARENT){
    elements = ElementList.GLOBAL_PARENT.querySelectorAll(tag);
  }
  else elements = document.querySelectorAll(tag);

  for (let element of elements) {
    this.list.push(new ElementEv(element, true));
  }

  return this;
}

ElementList.prototype.whereProp = function(values, cb) {
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

ElementList.prototype.event = function(ev, cb) {
  this.list.forEach(function (elementEv) {
    elementEv.element.addEventListener(ev, function (event) {
      event.element = elementEv;

      cb(event);
    });
  });

  return this;
}

ElementList.prototype.print = function() {
  let elementsToShow = [];

  this.list.forEach(function (e) {
    elementsToShow.push(e.element.outerHTML);
  });

  console.log(elementsToShow);

  return this;
}

ElementList.prototype.values = function(type) {
  let values = [];

  if (type == "checkbox") {
    this.list.forEach(function (elementEvCheckbox) {
      if (elementEvCheckbox.get().checked)
        values.push(elementEvCheckbox.element.value);
    });

    return values;
  }
}


function elements() {
return new ElementList();
}
