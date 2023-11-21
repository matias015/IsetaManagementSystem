// (function() {

//     // if a number is negative, it will be tranformed into a valid index
//     function IsNegative(i, arr) {
//       i = parseInt(i)
//       if (i < 0) return arr.length + i
//       else return i
//     }
  
//     // PROTOTYPE EXTENDER
//     function Add(p, n, f) {
//       if (p.prototype[n]) return
//       else p.prototype[n] = f
//     }
  
//     function AddStatic(p, n, f) {
//       if (p[n]) return
//       else p[n] = f
//     }
  
  
//     // methods
  
//     // Array._from()
//     AddStatic(Array, '_from', function(from) {
//       var arr = []
//       for (var i = 0; i < from.length; i++) {
//         arr[i] = from[i]
//       }
//       return arr
//     })
  
//     // Array._sum()
//     Add(Array, '_sum', function() {
//       var sum = 0
//       for (var i = 0; i < this.length; i++) {
//         sum = sum + this[i]
//       }
//       return sum
//     })
  
//     // Array._sort()
//     // sort by number, random, ASCII and reversed
//     Add(Array, '_sort', function(by, reverse) {
//       if (by == "number") this.sort(function(a, b) { return a - b })
//       else if (by == "random") this.sort(function() { return Math.random() - .5 })
//       else this.sort()
//       if (reverse) this.reverse()
//     })
  
//     // Array._noRepeated()
//     // delete duplicates
//     Add(Array, '_noRepeated', function() {
//       var output = []
//       for (var i = 0; i < this.length; i++) {
//         if (output.indexOf(this[i]) === -1) output.push(this[i])
//       }
//       return output
//     })
  
//     // Array._take() >>> VERIFIED
//     Add(Array, '_take', function(i) {
//       i = IsNegative(i, this)
//       return this[i]
//     })
  
//     // Array._cut() >>> VERIFIED
//     Add(Array, '_cut', function(start, end) {
//       start = IsNegative(start, this)
//       end = IsNegative(end, this)
//       return this.slice(start, end)
//     })
  
//     // Array._range() >>> VERIFIED
//     Add(Array, '_range', function() {
//       var min = 0,
//         max = 0,
//         i = 0,
//         el
//       for (i; i < this.length; i++) {
//         el = this[i]
//         if (el > max) max = el
//         if (el < min) min = el
//       }
//       return [min, max]
//     })
  
//     // Array._remove() >>> VERIFIED
//     Add(Array, '_remove', function(i) {
//       i = IsNegative(i, this)
//       return this.splice(i, 1)[0]
//     })
  
//     // Array._addAfter() >>> VERIFIED
//     Add(Array, '_addAfter', function(nw, i) {
//       i = IsNegative(i, this)
//       this.splice(i + 1, 0, nw)
//       return nw
//     })
  
//     // Array._scale() >>> VERIFIED
//     Add(Array, '_scale', function(ri, rf) {
//       var arr = Array._from(this)
//       if (!rf && ri) {
//         rf = [0, ri[1]]
//         ri = [0, ri[0]]
//       }
  
//       for (var i = 0; i < arr.length; i++) {
//         if (arr[i] instanceof Array) arr[i] = arr[i]._scale(ri, rf)
//         else arr[i] = (arr[i] - ri[0]) * (rf[1] - rf[0]) / (ri[1] - ri[0]) + rf[0]
//       }
//       return arr
//     })
  
//     // Date._diff() >>> VERIFIED
//     Add(Date, '_diff', function(date) {
//       if (!date) date = new Date()
//       if (date instanceof Date) date = date.getTime()
//       return ((date - this.getTime()) / 1000)
//     })
  
//     // Date._diff() >>> VERIFIED
//     AddStatic(Date, '_timeAgoString', function(time) {
//       if (time instanceof Date) time = time.getTime()
//       time = (new Date().getTime() - time) / 1000
  
//       if (time >= 31536000) return parseInt(time / y) + ' years ago'
//       else if (time >= 2628000) return parseInt(time / m) + ' months ago'
//       else if (time >= 604800) return parseInt(time / w) + ' weeks ago'
//       else if (time >= 86400) return parseInt(time / d) + ' days ago'
//       else if (time >= 3600) return parseInt(time / 3600) + ' hours ago'
//       else if (time >= 60) return parseInt(time / 60) + ' minutes ago'
//       else if (time < 10) return 'right now'
//       return parseInt(time) + ' seconds ago'
//     })
  
//     // window._redirect() >>> VERIFIED
//     AddStatic(window, '_redirect', function(to) {
//       window.location.replace(to)
//     })
  
//     // window._pageInfo() >>> VERIFIED
//     AddStatic(window, '_pageInfo', function() {
//       return {
//         url: window.location.href,
//         path: window.location.pathname,
//         port: window.location.port,
//         protocol: window.location.protocol,
//       }
//     })
  
//     // window._onPageInactive() >>> VERIFIED
//     AddStatic(window, '_onPageInactive', function(cb) {
//       document.addEventListener('visibilitychange', function() {
//         if (document.visibilityState == 'hidden') cb(false)
//         else cb(true)
//       })
//     })
  
//     // window._find() >>> VERIFIED
//     AddStatic(window, '_find', function(id, parent) {
//       if (!parent) parent = document
//       if (typeof parent == 'string') parent = document.querySelector(parent)
//       return parent.querySelector(id)
//     })
  
//     // window._findAll() >>> VERIFIED
//     AddStatic(window, '_findAll', function(id, parent) {
//       if (!parent) parent = document
//       if (typeof parent == 'string') parent = document.querySelector(parent)
//       return Array._from(parent.querySelectorAll(id))
//     })
  
//     // window._classesOf() >>> VERIFIED
//     AddStatic(window, '_classesOf', function(id) {
//       if (typeof id === 'string') id = document.querySelector(id)
//       return Array._from(id.classList)
//     })
  
//     // window._fillContent() >>> VERIFIED
//     Add(Array, '_fillContent', function(content) {
//       for (var i = 0; i < content.length; i++) {
//         this[i].textContent = content[i]
//       }
//     })
  
//     // window._eventByClass() >>> VERIFIED
//     AddStatic(window, '_eventByClass', function(ev, obj, el) {
//       if (!el) el = document
  
//       el.addEventListener(ev, function(e) {
//         var classes = e.target.classList
//         for (var cl of classes) {
//           if (cl in obj) {
//             var f = obj[cl]
//             return f(e)
//           }
//         }
//         if (obj.else) return obj.else(e)
//       })
//     })
  
//     // window._newNode() >>> VERIFIED
//     AddStatic(window, '_newNode', function(p) {
//       if (!p) p = {}
//       if (!p.tag) p.tag = 'div'
//       var e = document.createElement(p.tag)
//       e.innerHTML = p.content || ''
  
//       if (p.class) {
//         p.class.forEach(function(clss){
//           e.classList.add(clss)
//         })
//       }
//       if (p.attrs) {
//         Object.entries(p.attrs).forEach(entrie=>{
//           e.setAttribute(entrie[0],entrie[1])
//         })
//       }

//       if (p.parent) {
//         if (typeof p.parent === 'string') p.parent = document.querySelector(p.parent)
//         p.parent.appendChild(e)
//       }

//       if (p.childrens) {
//         p.childrens.forEach(child=>{
//           e.appendChild(child)
//         })
//       }

//       return e
//     })
  
//     // window._parent() >>> VERIFIED
//     AddStatic(window, '_parent', function(el, deep) {
  
//       if (isNaN(deep)) deep = 1
  
//       while (deep > 0) {
//         el = el.parentElement
//         deep--
//       }
//       return el
//     })
  
//     // window._move() >>> VERIFIED
//     Add(HTMLElement, '_move', function(newparent) {
//       this.parentElement.removeChild(this)
//       newparent.appendChild(this)
//     })
  
//     // window._remove() >>> VERIFIED
//     Add(HTMLElement, '_remove', function() {
//       this.parentElement.removeChild(this)
//     })
  
//     // window._visibility() >>> VERIFIED
//     Add(HTMLElement, '_visibility', function(op, display) {
//       this.style.opacity = op
//       this.style.display = display || 'block'
//     })
  
//     // window._toggle() >>> VERIFIED
//     AddStatic(window, '_toggle', function(el, el2, clss, ev) {
//       if (!ev) ev = 'click'
//       if (!clss) clss = 'hide'
  
//       if (typeof el === 'string') el = document.querySelector(el)
//       if (typeof el2 === 'string') el2 = document.querySelector(el2)
  
//       el.addEventListener(ev, () => {
//         el2.classList.toggle(clss)
//       })
//     })
  
//     // window._interception() >>> VERIFIED
//     AddStatic(window, '_interception', function(obj) {
//       var target,
//         r,
//         margin,
//         th,
//         cb2
  
//       if (!obj.whilenot) cb2 = false
//       else cb2 = true
  
//       r = obj.root || document
//       if (typeof r == 'string') r = document.querySelector(r)
  
//       if (!obj.delay) margin = '0px'
//       else margin = `${obj.delay * 1.5}px 0px -${obj.delay * 1.5}px 0px`
//       th = obj.th || 0.5
  
//       let io = new IntersectionObserver(function(ent) {
//         ent.forEach(e => {
//           if (e.isIntersecting) obj.cb()
//           else {
//             if (cb2) obj.whilenot()
//           }
//         })
//       }, { root: r, rootMargin: margin, threshold: th })
//       io.observe(target)
//       return io
//     })
  
//     // window._supported() >>> VERIFIED
//     AddStatic(window, '_supported', function(api, cb) {
//       if (api in navigator) {
//         if (cb) cb(true)
//         return true
//       } else {
//         if (cb) cb(false)
//         return false
//       }
//     })
  
//     // window._cbCopy() >>> VERIFIED
//     AddStatic(window, '_cbCopy', function(text) {
//       if (typeof text === 'object') text = JSON.stringify(text)
//       navigator.clipboard.writeText(text + "")
//         .catch(() => console.warn('unable to copy'))
//     })
  
//     // window.entries() >>> VERIFIED
//     AddStatic(window, '_entries', function(obj) { return Object.entries(obj) })
  
//     // window._storage() >>> VERIFIED
//     AddStatic(window, '_storage', function(entrie, type) {
//       if (type == 's' || type == 'session') type = sessionStorage
//       else type = localStorage
  
//       if (entrie.length === 1) return type.getItem(entrie[0])
//       else type.setItem(entrie[0], entrie[1])
//     })
  
//     // window._round() >>> VERIFIED
//     Add(Number, '_round', function(div) {
//       if (!div) div = 1
//       return Math.round(this * div) / div;
//     })
  
//     // window._scale() >>> VERIFIED
//     Add(Number, '_scale', function(ri, rf) {
//       if (ri.length == 2 && (!rf)) {
//         rf = [0, ri[1]]
//         ri = [0, ri[0]]
//       }
//       return (this - ri[0]) * (rf[1] - rf[0]) / (ri[1] - ri[0]) + rf[0]
//     })
  
//     // window.getPos() >>> VERIFIED
//     AddStatic(window, '_getPos', function(cb, ops) {
//       if (!ops) ops = {}
//       navigator.geolocation.getCurrentPosition(pos => {
//         return cb(null, pos.coords)
//       }, (err) => cb(err, null), ops)
//     })
  
  
//     var ScreenSizesRel = {
//       'xs': [320, 480],
//       's': [481, 768],
//       'm': [769, 1024],
//       'l': [1025, 1200],
//       'xl': [1201, 9999]
//     }
  
//     //window._screemQuery() >>> VERIFIED
//     AddStatic(window, '_screenQuery', function(size, cb, min, max) {
//       if (!min && !max) {
//         min = ScreenSizesRel[size][0]
//         max = ScreenSizesRel[size][1]
//       }
//       else if (!max && typeof min == 'number') {
//         if (screen.width >= min) return cb()
//       }
  
//       if (screen.width >= min && screen.width <= max) return cb()
//     })
  
//     // htmlelement._style() >>> VERIFIED
//     Add(HTMLElement, '_style', function(css) {
//       var el = this
//       Object.entries(css).forEach(function(p) {
//         el.style[p[0]] = p[1]
//       })
//     })
  
//     // window._getProp() >>> VERIFIED
//     Add(HTMLElement, '_getProp', function(p) {
//       return getComputedStyle(this)[p]
//     })
//   })()