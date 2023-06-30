/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
!function () {
  "use strict";

  function e(e) {
    return e[e.length - 1];
  }
  function t(e, ...t) {
    return t.forEach(t => {
      e.includes(t) || e.push(t);
    }), e;
  }
  function i(e, t) {
    return e ? e.split(t) : [];
  }
  function s(e, t, i) {
    return (void 0 === t || e >= t) && (void 0 === i || e <= i);
  }
  function n(e, t, i) {
    return e < t ? t : e > i ? i : e;
  }
  function a(e, t, i = {}, s = 0, n = "") {
    n += `<${Object.keys(i).reduce((e, t) => {
      let n = i[t];
      return "function" == typeof n && (n = n(s)), `${e} ${t}="${n}"`;
    }, e)}></${e}>`;
    const r = s + 1;
    return r < t ? a(e, t, i, r, n) : n;
  }
  function r(e) {
    return e.replace(/>\s+/g, ">").replace(/\s+</, "<");
  }
  function o(e) {
    return new Date(e).setHours(0, 0, 0, 0);
  }
  function d() {
    return new Date().setHours(0, 0, 0, 0);
  }
  function c(...e) {
    switch (e.length) {
      case 0:
        return d();
      case 1:
        return o(e[0]);
    }
    const t = new Date(0);
    return t.setFullYear(...e), t.setHours(0, 0, 0, 0);
  }
  function l(e, t) {
    const i = new Date(e);
    return i.setDate(i.getDate() + t);
  }
  function h(e, t) {
    const i = new Date(e),
      s = i.getMonth() + t;
    let n = s % 12;
    n < 0 && (n += 12);
    const a = i.setMonth(s);
    return i.getMonth() !== n ? i.setDate(0) : a;
  }
  function u(e, t) {
    const i = new Date(e),
      s = i.getMonth(),
      n = i.setFullYear(i.getFullYear() + t);
    return 1 === s && 2 === i.getMonth() ? i.setDate(0) : n;
  }
  function f(e, t) {
    return (e - t + 7) % 7;
  }
  function p(e, t, i = 0) {
    const s = new Date(e).getDay();
    return l(e, f(t, i) - f(s, i));
  }
  function m(e, t) {
    return Math.round((e - t) / 6048e5) + 1;
  }
  function w(e) {
    const t = p(e, 4, 1);
    return m(t, p(new Date(t).setMonth(0, 4), 4, 1));
  }
  function g(e, t) {
    const i = p(new Date(e).setMonth(0, 1), t, t),
      s = p(e, t, t),
      n = m(s, i);
    if (n < 53) return n;
    return s === p(new Date(e).setDate(32), t, t) ? 1 : n;
  }
  function y(e) {
    return g(e, 0);
  }
  function D(e) {
    return g(e, 6);
  }
  function k(e, t) {
    const i = new Date(e).getFullYear();
    return Math.floor(i / t) * t;
  }
  function b(e, t, i) {
    if (1 !== t && 2 !== t) return e;
    const s = new Date(e);
    return 1 === t ? i ? s.setMonth(s.getMonth() + 1, 0) : s.setDate(1) : i ? s.setFullYear(s.getFullYear() + 1, 0, 0) : s.setMonth(0, 1), s.setHours(0, 0, 0, 0);
  }
  const v = /dd?|DD?|mm?|MM?|yy?(?:yy)?/,
    x = /[\s!-/:-@[-`{-~年月日]+/;
  let M = {};
  const O = {
      y: (e, t) => new Date(e).setFullYear(parseInt(t, 10)),
      m(e, t, i) {
        const s = new Date(e);
        let n = parseInt(t, 10) - 1;
        if (isNaN(n)) {
          if (!t) return NaN;
          const e = t.toLowerCase(),
            s = t => t.toLowerCase().startsWith(e);
          if (n = i.monthsShort.findIndex(s), n < 0 && (n = i.months.findIndex(s)), n < 0) return NaN;
        }
        return s.setMonth(n), s.getMonth() !== N(n) ? s.setDate(0) : s.getTime();
      },
      d: (e, t) => new Date(e).setDate(parseInt(t, 10))
    },
    S = {
      d: e => e.getDate(),
      dd: e => C(e.getDate(), 2),
      D: (e, t) => t.daysShort[e.getDay()],
      DD: (e, t) => t.days[e.getDay()],
      m: e => e.getMonth() + 1,
      mm: e => C(e.getMonth() + 1, 2),
      M: (e, t) => t.monthsShort[e.getMonth()],
      MM: (e, t) => t.months[e.getMonth()],
      y: e => e.getFullYear(),
      yy: e => C(e.getFullYear(), 2).slice(-2),
      yyyy: e => C(e.getFullYear(), 4)
    };
  function N(e) {
    return e > -1 ? e % 12 : N(e + 12);
  }
  function C(e, t) {
    return e.toString().padStart(t, "0");
  }
  function F(t) {
    if ("string" != typeof t) throw new Error("Invalid date format.");
    if (t in M) return M[t];
    const i = t.split(v),
      s = t.match(new RegExp(v, "g"));
    if (0 === i.length || !s) throw new Error("Invalid date format.");
    const n = s.map(e => S[e]),
      a = Object.keys(O).reduce((e, t) => (s.find(e => "D" !== e[0] && e[0].toLowerCase() === t) && e.push(t), e), []);
    return M[t] = {
      parser(e, t) {
        const i = e.split(x).reduce((e, t, i) => {
          if (t.length > 0 && s[i]) {
            const n = s[i][0];
            "M" === n ? e.m = t : "D" !== n && (e[n] = t);
          }
          return e;
        }, {});
        return a.reduce((e, s) => {
          const n = O[s](e, i[s], t);
          return isNaN(n) ? e : n;
        }, d());
      },
      formatter: (t, s) => n.reduce((e, n, a) => e + `${i[a]}${n(t, s)}`, "") + e(i)
    };
  }
  function V(e, t, i) {
    if (e instanceof Date || "number" == typeof e) {
      const t = o(e);
      return isNaN(t) ? void 0 : t;
    }
    if (e) {
      if ("today" === e) return d();
      if (t && t.toValue) {
        const s = t.toValue(e, t, i);
        return isNaN(s) ? void 0 : o(s);
      }
      return F(t).parser(e, i);
    }
  }
  function B(e, t, i) {
    if (isNaN(e) || !e && 0 !== e) return "";
    const s = "number" == typeof e ? new Date(e) : e;
    return t.toDisplay ? t.toDisplay(s, t, i) : F(t).formatter(s, i);
  }
  const E = document.createRange();
  function A(e) {
    return E.createContextualFragment(e);
  }
  function L(e) {
    return e.parentElement || (e.parentNode instanceof ShadowRoot ? e.parentNode.host : void 0);
  }
  function Y(e) {
    return e.getRootNode().activeElement === e;
  }
  function W(e) {
    "none" !== e.style.display && (e.style.display && (e.dataset.styleDisplay = e.style.display), e.style.display = "none");
  }
  function _(e) {
    "none" === e.style.display && (e.dataset.styleDisplay ? (e.style.display = e.dataset.styleDisplay, delete e.dataset.styleDisplay) : e.style.display = "");
  }
  function K(e) {
    e.firstChild && (e.removeChild(e.firstChild), K(e));
  }
  const R = new WeakMap(),
    {
      addEventListener: j,
      removeEventListener: T
    } = EventTarget.prototype;
  function H(e, t) {
    let i = R.get(e);
    i || (i = [], R.set(e, i)), t.forEach(e => {
      j.call(...e), i.push(e);
    });
  }
  function I(e) {
    let t = R.get(e);
    t && (t.forEach(e => {
      T.call(...e);
    }), R.delete(e));
  }
  if (!Event.prototype.composedPath) {
    const e = (t, i = []) => {
      let s;
      return i.push(t), t.parentNode ? s = t.parentNode : t.host ? s = t.host : t.defaultView && (s = t.defaultView), s ? e(s, i) : i;
    };
    Event.prototype.composedPath = function () {
      return e(this.target);
    };
  }
  function $(e, t, i) {
    const [s, ...n] = e;
    return t(s) ? s : s !== i && "HTML" !== s.tagName && 0 !== n.length ? $(n, t, i) : void 0;
  }
  function P(e, t) {
    const i = "function" == typeof t ? t : e => e instanceof Element && e.matches(t);
    return $(e.composedPath(), i, e.currentTarget);
  }
  const J = {
      en: {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear",
        titleFormat: "MM y"
      }
    },
    U = {
      autohide: !1,
      beforeShowDay: null,
      beforeShowDecade: null,
      beforeShowMonth: null,
      beforeShowYear: null,
      clearButton: !1,
      dateDelimiter: ",",
      datesDisabled: [],
      daysOfWeekDisabled: [],
      daysOfWeekHighlighted: [],
      defaultViewDate: void 0,
      disableTouchKeyboard: !1,
      enableOnReadonly: !0,
      format: "mm/dd/yyyy",
      language: "en",
      maxDate: null,
      maxNumberOfDates: 1,
      maxView: 3,
      minDate: null,
      nextArrow: "»",
      orientation: "auto",
      pickLevel: 0,
      prevArrow: "«",
      showDaysOfWeek: !0,
      showOnClick: !0,
      showOnFocus: !0,
      startView: 0,
      title: "",
      todayButton: !1,
      todayButtonMode: 0,
      todayHighlight: !1,
      updateOnBlur: !0,
      weekNumbers: 0,
      weekStart: 0
    },
    {
      language: q,
      format: z,
      weekStart: X
    } = U;
  function G(e, i) {
    return e.length < 6 && i >= 0 && i < 7 ? t(e, i) : e;
  }
  function Q(e, t) {
    switch (4 === e ? 6 === t ? 3 : !t + 1 : e) {
      case 1:
        return w;
      case 2:
        return y;
      case 3:
        return D;
    }
  }
  function Z(e, t, i) {
    return t.weekStart = e, t.weekEnd = (e + 6) % 7, 4 === i && (t.getWeekNumber = Q(4, e)), e;
  }
  function ee(e, t, i, s) {
    const n = V(e, t, i);
    return void 0 !== n ? n : s;
  }
  function te(e, t, i = 3) {
    const s = parseInt(e, 10);
    return s >= 0 && s <= i ? s : t;
  }
  function ie(e, t, i, s = void 0) {
    t in e && (i in e || (e[i] = s ? s(e[t]) : e[t]), delete e[t]);
  }
  function se(e, i) {
    const s = Object.assign({}, e),
      n = {},
      a = i.constructor.locales,
      r = !!i.rangeSideIndex;
    let {
      datesDisabled: o,
      format: d,
      language: l,
      locale: h,
      maxDate: u,
      maxView: f,
      minDate: p,
      pickLevel: m,
      startView: w,
      weekNumbers: g,
      weekStart: y
    } = i.config || {};
    if (ie(s, "calendarWeeks", "weekNumbers", e => e ? 1 : 0), ie(s, "clearBtn", "clearButton"), ie(s, "todayBtn", "todayButton"), ie(s, "todayBtnMode", "todayButtonMode"), s.language) {
      let e;
      if (s.language !== l && (a[s.language] ? e = s.language : (e = s.language.split("-")[0], a[e] || (e = !1))), delete s.language, e) {
        l = n.language = e;
        const t = h || a[q];
        h = Object.assign({
          format: z,
          weekStart: X
        }, a[q]), l !== q && Object.assign(h, a[l]), n.locale = h, d === t.format && (d = n.format = h.format), y === t.weekStart && (y = Z(h.weekStart, n, g));
      }
    }
    if (s.format) {
      const e = "function" == typeof s.format.toDisplay,
        t = "function" == typeof s.format.toValue,
        i = v.test(s.format);
      (e && t || i) && (d = n.format = s.format), delete s.format;
    }
    let D = m;
    "pickLevel" in s && (D = te(s.pickLevel, m, 2), delete s.pickLevel), D !== m && (D > m && ("minDate" in s || (s.minDate = p), "maxDate" in s || (s.maxDate = u)), o && !s.datesDisabled && (s.datesDisabled = []), m = n.pickLevel = D);
    let k = p,
      x = u;
    if ("minDate" in s) {
      const e = c(0, 0, 1);
      k = null === s.minDate ? e : ee(s.minDate, d, h, k), k !== e && (k = b(k, m, !1)), delete s.minDate;
    }
    if ("maxDate" in s && (x = null === s.maxDate ? void 0 : ee(s.maxDate, d, h, x), void 0 !== x && (x = b(x, m, !0)), delete s.maxDate), x < k ? (p = n.minDate = x, u = n.maxDate = k) : (p !== k && (p = n.minDate = k), u !== x && (u = n.maxDate = x)), s.datesDisabled) {
      const e = s.datesDisabled;
      if ("function" == typeof e) n.datesDisabled = null, n.checkDisabled = (t, i) => e(new Date(t), i, r);else {
        const i = n.datesDisabled = e.reduce((e, i) => {
          const s = V(i, d, h);
          return void 0 !== s ? t(e, b(s, m, r)) : e;
        }, []);
        n.checkDisabled = e => i.includes(e);
      }
      delete s.datesDisabled;
    }
    if ("defaultViewDate" in s) {
      const e = V(s.defaultViewDate, d, h);
      void 0 !== e && (n.defaultViewDate = e), delete s.defaultViewDate;
    }
    if ("weekStart" in s) {
      const e = Number(s.weekStart) % 7;
      isNaN(e) || (y = Z(e, n, g)), delete s.weekStart;
    }
    if (s.daysOfWeekDisabled && (n.daysOfWeekDisabled = s.daysOfWeekDisabled.reduce(G, []), delete s.daysOfWeekDisabled), s.daysOfWeekHighlighted && (n.daysOfWeekHighlighted = s.daysOfWeekHighlighted.reduce(G, []), delete s.daysOfWeekHighlighted), "weekNumbers" in s) {
      let e = s.weekNumbers;
      if (e) {
        const t = "function" == typeof e ? (t, i) => e(new Date(t), i) : Q(e = parseInt(e, 10), y);
        t && (g = n.weekNumbers = e, n.getWeekNumber = t);
      } else g = n.weekNumbers = 0, n.getWeekNumber = null;
      delete s.weekNumbers;
    }
    if ("maxNumberOfDates" in s) {
      const e = parseInt(s.maxNumberOfDates, 10);
      e >= 0 && (n.maxNumberOfDates = e, n.multidate = 1 !== e), delete s.maxNumberOfDates;
    }
    s.dateDelimiter && (n.dateDelimiter = String(s.dateDelimiter), delete s.dateDelimiter);
    let M = f;
    "maxView" in s && (M = te(s.maxView, f), delete s.maxView), M = m > M ? m : M, M !== f && (f = n.maxView = M);
    let O = w;
    if ("startView" in s && (O = te(s.startView, O), delete s.startView), O < m ? O = m : O > f && (O = f), O !== w && (n.startView = O), s.prevArrow) {
      const e = A(s.prevArrow);
      e.childNodes.length > 0 && (n.prevArrow = e.childNodes), delete s.prevArrow;
    }
    if (s.nextArrow) {
      const e = A(s.nextArrow);
      e.childNodes.length > 0 && (n.nextArrow = e.childNodes), delete s.nextArrow;
    }
    if ("disableTouchKeyboard" in s && (n.disableTouchKeyboard = "ontouchstart" in document && !!s.disableTouchKeyboard, delete s.disableTouchKeyboard), s.orientation) {
      const e = s.orientation.toLowerCase().split(/\s+/g);
      n.orientation = {
        x: e.find(e => "left" === e || "right" === e) || "auto",
        y: e.find(e => "top" === e || "bottom" === e) || "auto"
      }, delete s.orientation;
    }
    if ("todayButtonMode" in s) {
      switch (s.todayButtonMode) {
        case 0:
        case 1:
          n.todayButtonMode = s.todayButtonMode;
      }
      delete s.todayButtonMode;
    }
    return Object.entries(s).forEach(([e, t]) => {
      void 0 !== t && e in U && (n[e] = t);
    }), n;
  }
  const ne = {
    show: {
      key: "ArrowDown"
    },
    hide: null,
    toggle: {
      key: "Escape"
    },
    prevButton: {
      key: "ArrowLeft",
      ctrlOrMetaKey: !0
    },
    nextButton: {
      key: "ArrowRight",
      ctrlOrMetaKey: !0
    },
    viewSwitch: {
      key: "ArrowUp",
      ctrlOrMetaKey: !0
    },
    clearButton: {
      key: "Backspace",
      ctrlOrMetaKey: !0
    },
    todayButton: {
      key: ".",
      ctrlOrMetaKey: !0
    },
    exitEditMode: {
      key: "ArrowDown",
      ctrlOrMetaKey: !0
    }
  };
  const ae = r('<div class="datepicker">\n  <div class="datepicker-picker">\n    <div class="datepicker-header">\n      <div class="datepicker-title"></div>\n      <div class="datepicker-controls">\n        <button type="button" class="%buttonClass% prev-button prev-btn"></button>\n        <button type="button" class="%buttonClass% view-switch"></button>\n        <button type="button" class="%buttonClass% next-button next-btn"></button>\n      </div>\n    </div>\n    <div class="datepicker-main"></div>\n    <div class="datepicker-footer">\n      <div class="datepicker-controls">\n        <button type="button" class="%buttonClass% today-button today-btn"></button>\n        <button type="button" class="%buttonClass% clear-button clear-btn"></button>\n      </div>\n    </div>\n  </div>\n</div>'),
    re = r(`<div class="days">\n  <div class="days-of-week">${a("span", 7, {
      class: "dow"
    })}</div>\n  <div class="datepicker-grid">${a("span", 42)}</div>\n</div>`),
    oe = r(`<div class="week-numbers calendar-weeks">\n  <div class="days-of-week"><span class="dow"></span></div>\n  <div class="weeks">${a("span", 6, {
      class: "week"
    })}</div>\n</div>`);
  class de {
    constructor(e, t) {
      Object.assign(this, t, {
        picker: e,
        element: A('<div class="datepicker-view"></div>').firstChild,
        selected: [],
        isRangeEnd: !!e.datepicker.rangeSideIndex
      }), this.init(this.picker.datepicker.config);
    }
    init(e) {
      "pickLevel" in e && (this.isMinView = this.id === e.pickLevel), this.setOptions(e), this.updateFocus(), this.updateSelection();
    }
    prepareForRender(e, t, i) {
      this.disabled = [];
      const s = this.picker;
      s.setViewSwitchLabel(e), s.setPrevButtonDisabled(t), s.setNextButtonDisabled(i);
    }
    setDisabled(e, i) {
      i.add("disabled"), t(this.disabled, e);
    }
    performBeforeHook(e, t) {
      let i = this.beforeShow(new Date(t));
      switch (typeof i) {
        case "boolean":
          i = {
            enabled: i
          };
          break;
        case "string":
          i = {
            classes: i
          };
      }
      if (i) {
        const s = e.classList;
        if (!1 === i.enabled && this.setDisabled(t, s), i.classes) {
          const e = i.classes.split(/\s+/);
          s.add(...e), e.includes("disabled") && this.setDisabled(t, s);
        }
        i.content && function (e, t) {
          K(e), t instanceof DocumentFragment ? e.appendChild(t) : "string" == typeof t ? e.appendChild(A(t)) : "function" == typeof t.forEach && t.forEach(t => {
            e.appendChild(t);
          });
        }(e, i.content);
      }
    }
    renderCell(e, t, i, s, {
      selected: n,
      range: a
    }, r, o = []) {
      e.textContent = t, this.isMinView && (e.dataset.date = s);
      const d = e.classList;
      if (e.className = `datepicker-cell ${this.cellClass}`, i < this.first ? d.add("prev") : i > this.last && d.add("next"), d.add(...o), (r || this.checkDisabled(s, this.id)) && this.setDisabled(s, d), a) {
        const [e, t] = a;
        i > e && i < t && d.add("range"), i === e && d.add("range-start"), i === t && d.add("range-end");
      }
      n.includes(i) && d.add("selected"), i === this.focused && d.add("focused"), this.beforeShow && this.performBeforeHook(e, s);
    }
    refreshCell(e, t, i, [s, n]) {
      const a = e.classList;
      a.remove("range", "range-start", "range-end", "selected", "focused"), t > s && t < n && a.add("range"), t === s && a.add("range-start"), t === n && a.add("range-end"), i.includes(t) && a.add("selected"), t === this.focused && a.add("focused");
    }
    changeFocusedCell(e) {
      this.grid.querySelectorAll(".focused").forEach(e => {
        e.classList.remove("focused");
      }), this.grid.children[e].classList.add("focused");
    }
  }
  class ce extends de {
    constructor(e) {
      super(e, {
        id: 0,
        name: "days",
        cellClass: "day"
      });
    }
    init(e, t = !0) {
      if (t) {
        const e = A(re).firstChild;
        this.dow = e.firstChild, this.grid = e.lastChild, this.element.appendChild(e);
      }
      super.init(e);
    }
    setOptions(e) {
      let t;
      if ("minDate" in e && (this.minDate = e.minDate), "maxDate" in e && (this.maxDate = e.maxDate), e.checkDisabled && (this.checkDisabled = e.checkDisabled), e.daysOfWeekDisabled && (this.daysOfWeekDisabled = e.daysOfWeekDisabled, t = !0), e.daysOfWeekHighlighted && (this.daysOfWeekHighlighted = e.daysOfWeekHighlighted), "todayHighlight" in e && (this.todayHighlight = e.todayHighlight), "weekStart" in e && (this.weekStart = e.weekStart, this.weekEnd = e.weekEnd, t = !0), e.locale) {
        const i = this.locale = e.locale;
        this.dayNames = i.daysMin, this.switchLabelFormat = i.titleFormat, t = !0;
      }
      if ("beforeShowDay" in e && (this.beforeShow = "function" == typeof e.beforeShowDay ? e.beforeShowDay : void 0), "weekNumbers" in e) if (e.weekNumbers && !this.weekNumbers) {
        const e = A(oe).firstChild;
        this.weekNumbers = {
          element: e,
          dow: e.firstChild,
          weeks: e.lastChild
        }, this.element.insertBefore(e, this.element.firstChild);
      } else this.weekNumbers && !e.weekNumbers && (this.element.removeChild(this.weekNumbers.element), this.weekNumbers = null);
      "getWeekNumber" in e && (this.getWeekNumber = e.getWeekNumber), "showDaysOfWeek" in e && (e.showDaysOfWeek ? (_(this.dow), this.weekNumbers && _(this.weekNumbers.dow)) : (W(this.dow), this.weekNumbers && W(this.weekNumbers.dow))), t && Array.from(this.dow.children).forEach((e, t) => {
        const i = (this.weekStart + t) % 7;
        e.textContent = this.dayNames[i], e.className = this.daysOfWeekDisabled.includes(i) ? "dow disabled" : "dow";
      });
    }
    updateFocus() {
      const e = new Date(this.picker.viewDate),
        t = e.getFullYear(),
        i = e.getMonth(),
        s = c(t, i, 1),
        n = p(s, this.weekStart, this.weekStart);
      this.first = s, this.last = c(t, i + 1, 0), this.start = n, this.focused = this.picker.viewDate;
    }
    updateSelection() {
      const {
        dates: e,
        rangepicker: t
      } = this.picker.datepicker;
      this.selected = e, t && (this.range = t.dates);
    }
    render() {
      if (this.today = this.todayHighlight ? d() : void 0, this.prepareForRender(B(this.focused, this.switchLabelFormat, this.locale), this.first <= this.minDate, this.last >= this.maxDate), this.weekNumbers) {
        const e = this.weekStart,
          t = p(this.first, e, e);
        Array.from(this.weekNumbers.weeks.children).forEach((i, s) => {
          const n = l(t, 7 * s);
          i.textContent = this.getWeekNumber(n, e), s > 3 && i.classList[n > this.last ? "add" : "remove"]("next");
        });
      }
      Array.from(this.grid.children).forEach((e, t) => {
        const i = l(this.start, t),
          s = new Date(i),
          n = s.getDay(),
          a = [];
        this.today === i && a.push("today"), this.daysOfWeekHighlighted.includes(n) && a.push("highlighted"), this.renderCell(e, s.getDate(), i, i, this, i < this.minDate || i > this.maxDate || this.daysOfWeekDisabled.includes(n), a);
      });
    }
    refresh() {
      const e = this.range || [];
      Array.from(this.grid.children).forEach(t => {
        this.refreshCell(t, Number(t.dataset.date), this.selected, e);
      });
    }
    refreshFocus() {
      this.changeFocusedCell(Math.round((this.focused - this.start) / 864e5));
    }
  }
  function le(e, t) {
    if (!e || !e[0] || !e[1]) return;
    const [[i, s], [n, a]] = e;
    return i > t || n < t ? void 0 : [i === t ? s : -1, n === t ? a : 12];
  }
  class he extends de {
    constructor(e) {
      super(e, {
        id: 1,
        name: "months",
        cellClass: "month"
      });
    }
    init(e, t = !0) {
      t && (this.grid = this.element, this.element.classList.add("months", "datepicker-grid"), this.grid.appendChild(A(a("span", 12, {
        "data-month": e => e
      }))), this.first = 0, this.last = 11), super.init(e);
    }
    setOptions(e) {
      if (e.locale && (this.monthNames = e.locale.monthsShort), "minDate" in e) if (void 0 === e.minDate) this.minYear = this.minMonth = this.minDate = void 0;else {
        const t = new Date(e.minDate);
        this.minYear = t.getFullYear(), this.minMonth = t.getMonth(), this.minDate = t.setDate(1);
      }
      if ("maxDate" in e) if (void 0 === e.maxDate) this.maxYear = this.maxMonth = this.maxDate = void 0;else {
        const t = new Date(e.maxDate);
        this.maxYear = t.getFullYear(), this.maxMonth = t.getMonth(), this.maxDate = c(this.maxYear, this.maxMonth + 1, 0);
      }
      e.checkDisabled && (this.checkDisabled = this.isMinView || null === e.datesDisabled ? e.checkDisabled : () => !1), "beforeShowMonth" in e && (this.beforeShow = "function" == typeof e.beforeShowMonth ? e.beforeShowMonth : void 0);
    }
    updateFocus() {
      const e = new Date(this.picker.viewDate);
      this.year = e.getFullYear(), this.focused = e.getMonth();
    }
    updateSelection() {
      const {
        dates: e,
        rangepicker: i
      } = this.picker.datepicker;
      this.selected = e.reduce((e, i) => {
        const s = new Date(i),
          n = s.getFullYear(),
          a = s.getMonth();
        return void 0 === e[n] ? e[n] = [a] : t(e[n], a), e;
      }, {}), i && i.dates && (this.range = i.dates.map(e => {
        const t = new Date(e);
        return isNaN(t) ? void 0 : [t.getFullYear(), t.getMonth()];
      }));
    }
    render() {
      this.prepareForRender(this.year, this.year <= this.minYear, this.year >= this.maxYear);
      const e = this.selected[this.year] || [],
        t = this.year < this.minYear || this.year > this.maxYear,
        i = this.year === this.minYear,
        s = this.year === this.maxYear,
        n = le(this.range, this.year);
      Array.from(this.grid.children).forEach((a, r) => {
        const o = b(new Date(this.year, r, 1), 1, this.isRangeEnd);
        this.renderCell(a, this.monthNames[r], r, o, {
          selected: e,
          range: n
        }, t || i && r < this.minMonth || s && r > this.maxMonth);
      });
    }
    refresh() {
      const e = this.selected[this.year] || [],
        t = le(this.range, this.year) || [];
      Array.from(this.grid.children).forEach((i, s) => {
        this.refreshCell(i, s, e, t);
      });
    }
    refreshFocus() {
      this.changeFocusedCell(this.focused);
    }
  }
  class ue extends de {
    constructor(e, t) {
      super(e, t);
    }
    init(e, t = !0) {
      var i;
      t && (this.navStep = 10 * this.step, this.beforeShowOption = `beforeShow${(i = this.cellClass, [...i].reduce((e, t, i) => e + (i ? t : t.toUpperCase()), ""))}`, this.grid = this.element, this.element.classList.add(this.name, "datepicker-grid"), this.grid.appendChild(A(a("span", 12)))), super.init(e);
    }
    setOptions(e) {
      if ("minDate" in e && (void 0 === e.minDate ? this.minYear = this.minDate = void 0 : (this.minYear = k(e.minDate, this.step), this.minDate = c(this.minYear, 0, 1))), "maxDate" in e && (void 0 === e.maxDate ? this.maxYear = this.maxDate = void 0 : (this.maxYear = k(e.maxDate, this.step), this.maxDate = c(this.maxYear, 11, 31))), e.checkDisabled && (this.checkDisabled = this.isMinView || null === e.datesDisabled ? e.checkDisabled : () => !1), this.beforeShowOption in e) {
        const t = e[this.beforeShowOption];
        this.beforeShow = "function" == typeof t ? t : void 0;
      }
    }
    updateFocus() {
      const e = new Date(this.picker.viewDate),
        t = k(e, this.navStep),
        i = t + 9 * this.step;
      this.first = t, this.last = i, this.start = t - this.step, this.focused = k(e, this.step);
    }
    updateSelection() {
      const {
        dates: e,
        rangepicker: i
      } = this.picker.datepicker;
      this.selected = e.reduce((e, i) => t(e, k(i, this.step)), []), i && i.dates && (this.range = i.dates.map(e => {
        if (void 0 !== e) return k(e, this.step);
      }));
    }
    render() {
      this.prepareForRender(`${this.first}-${this.last}`, this.first <= this.minYear, this.last >= this.maxYear), Array.from(this.grid.children).forEach((e, t) => {
        const i = this.start + t * this.step,
          s = b(new Date(i, 0, 1), 2, this.isRangeEnd);
        e.dataset.year = i, this.renderCell(e, i, i, s, this, i < this.minYear || i > this.maxYear);
      });
    }
    refresh() {
      const e = this.range || [];
      Array.from(this.grid.children).forEach(t => {
        this.refreshCell(t, Number(t.textContent), this.selected, e);
      });
    }
    refreshFocus() {
      this.changeFocusedCell(Math.round((this.focused - this.start) / this.step));
    }
  }
  function fe(e, t) {
    const i = {
      date: e.getDate(),
      viewDate: new Date(e.picker.viewDate),
      viewId: e.picker.currentView.id,
      datepicker: e
    };
    e.element.dispatchEvent(new CustomEvent(t, {
      detail: i
    }));
  }
  function pe(e, t) {
    const {
        config: i,
        picker: s
      } = e,
      {
        currentView: a,
        viewDate: r
      } = s;
    let o;
    switch (a.id) {
      case 0:
        o = h(r, t);
        break;
      case 1:
        o = u(r, t);
        break;
      default:
        o = u(r, t * a.navStep);
    }
    o = n(o, i.minDate, i.maxDate), s.changeFocus(o).render();
  }
  function me(e) {
    const t = e.picker.currentView.id;
    t !== e.config.maxView && e.picker.changeView(t + 1).render();
  }
  function we(e) {
    e.setDate({
      clear: !0
    });
  }
  function ge(e) {
    const t = d();
    1 === e.config.todayButtonMode ? e.setDate(t, {
      forceRefresh: !0,
      viewDate: t
    }) : e.setFocusedDate(t, !0);
  }
  function ye(e) {
    const t = () => {
        e.config.updateOnBlur ? e.update({
          revert: !0
        }) : e.refresh("input"), e.hide();
      },
      i = e.element;
    Y(i) ? i.addEventListener("blur", t, {
      once: !0
    }) : t();
  }
  function De(e, t) {
    const i = e.picker,
      s = new Date(i.viewDate),
      n = i.currentView.id,
      a = 1 === n ? h(s, t - s.getMonth()) : u(s, t - s.getFullYear());
    i.changeFocus(a).changeView(n - 1).render();
  }
  function ke(e) {
    me(e);
  }
  function be(e) {
    pe(e, -1);
  }
  function ve(e) {
    pe(e, 1);
  }
  function xe(e, t) {
    const i = P(t, ".datepicker-cell");
    if (!i || i.classList.contains("disabled")) return;
    const {
        id: s,
        isMinView: n
      } = e.picker.currentView,
      a = i.dataset;
    n ? e.setDate(Number(a.date)) : De(e, Number(1 === s ? a.month : a.year));
  }
  function Me(e) {
    e.preventDefault();
  }
  const Oe = ["left", "top", "right", "bottom"].reduce((e, t) => (e[t] = `datepicker-orient-${t}`, e), {}),
    Se = e => e ? `${e}px` : e;
  function Ne(e, t) {
    if ("title" in t && (t.title ? (e.controls.title.textContent = t.title, _(e.controls.title)) : (e.controls.title.textContent = "", W(e.controls.title))), t.prevArrow) {
      const i = e.controls.prevButton;
      K(i), t.prevArrow.forEach(e => {
        i.appendChild(e.cloneNode(!0));
      });
    }
    if (t.nextArrow) {
      const i = e.controls.nextButton;
      K(i), t.nextArrow.forEach(e => {
        i.appendChild(e.cloneNode(!0));
      });
    }
    if (t.locale && (e.controls.todayButton.textContent = t.locale.today, e.controls.clearButton.textContent = t.locale.clear), "todayButton" in t && (t.todayButton ? _(e.controls.todayButton) : W(e.controls.todayButton)), "minDate" in t || "maxDate" in t) {
      const {
        minDate: t,
        maxDate: i
      } = e.datepicker.config;
      e.controls.todayButton.disabled = !s(d(), t, i);
    }
    "clearButton" in t && (t.clearButton ? _(e.controls.clearButton) : W(e.controls.clearButton));
  }
  function Ce(t) {
    const {
      dates: i,
      config: s,
      rangeSideIndex: a
    } = t;
    return n(i.length > 0 ? e(i) : b(s.defaultViewDate, s.pickLevel, a), s.minDate, s.maxDate);
  }
  function Fe(e, t) {
    "_oldViewDate" in e || t === e.viewDate || (e._oldViewDate = e.viewDate), e.viewDate = t;
    const {
        id: i,
        year: s,
        first: n,
        last: a
      } = e.currentView,
      r = new Date(t).getFullYear();
    switch (i) {
      case 0:
        return t < n || t > a;
      case 1:
        return r !== s;
      default:
        return r < n || r > a;
    }
  }
  function Ve(e) {
    return window.getComputedStyle(e).direction;
  }
  function Be(e) {
    const t = L(e);
    if (t !== document.body && t) return "visible" !== window.getComputedStyle(t).overflow ? t : Be(t);
  }
  class Ee {
    constructor(e) {
      const {
          config: t,
          inputField: i
        } = this.datepicker = e,
        s = ae.replace(/%buttonClass%/g, t.buttonClass),
        n = this.element = A(s).firstChild,
        [a, r, o] = n.firstChild.children,
        d = a.firstElementChild,
        [c, l, h] = a.lastElementChild.children,
        [u, f] = o.firstChild.children,
        p = {
          title: d,
          prevButton: c,
          viewSwitch: l,
          nextButton: h,
          todayButton: u,
          clearButton: f
        };
      this.main = r, this.controls = p;
      const m = i ? "dropdown" : "inline";
      n.classList.add(`datepicker-${m}`), Ne(this, t), this.viewDate = Ce(e), H(e, [[n, "mousedown", Me], [r, "click", xe.bind(null, e)], [p.viewSwitch, "click", ke.bind(null, e)], [p.prevButton, "click", be.bind(null, e)], [p.nextButton, "click", ve.bind(null, e)], [p.todayButton, "click", ge.bind(null, e)], [p.clearButton, "click", we.bind(null, e)]]), this.views = [new ce(this), new he(this), new ue(this, {
        id: 2,
        name: "years",
        cellClass: "year",
        step: 1
      }), new ue(this, {
        id: 3,
        name: "decades",
        cellClass: "decade",
        step: 10
      })], this.currentView = this.views[t.startView], this.currentView.render(), this.main.appendChild(this.currentView.element), t.container ? t.container.appendChild(this.element) : i.after(this.element);
    }
    setOptions(e) {
      Ne(this, e), this.views.forEach(t => {
        t.init(e, !1);
      }), this.currentView.render();
    }
    detach() {
      this.element.remove();
    }
    show() {
      if (this.active) return;
      const {
          datepicker: e,
          element: t
        } = this,
        i = e.inputField;
      if (i) {
        const s = Ve(i);
        s !== Ve(L(t)) ? t.dir = s : t.dir && t.removeAttribute("dir"), t.style.visibility = "hidden", t.classList.add("active"), this.place(), t.style.visibility = "", e.config.disableTouchKeyboard && i.blur();
      } else t.classList.add("active");
      this.active = !0, fe(e, "show");
    }
    hide() {
      this.active && (this.datepicker.exitEditMode(), this.element.classList.remove("active"), this.active = !1, fe(this.datepicker, "hide"));
    }
    place() {
      const {
          classList: e,
          offsetParent: t,
          style: i
        } = this.element,
        {
          config: s,
          inputField: n
        } = this.datepicker,
        {
          width: a,
          height: r
        } = this.element.getBoundingClientRect(),
        {
          left: o,
          top: d,
          right: c,
          bottom: l,
          width: h,
          height: u
        } = n.getBoundingClientRect();
      let {
          x: f,
          y: p
        } = s.orientation,
        m = o,
        w = d;
      if (t !== document.body && t) {
        const e = t.getBoundingClientRect();
        m -= e.left - t.scrollLeft, w -= e.top - t.scrollTop;
      } else m += window.scrollX, w += window.scrollY;
      const g = Be(n);
      let y = 0,
        D = 0,
        {
          clientWidth: k,
          clientHeight: b
        } = document.documentElement;
      if (g) {
        const e = g.getBoundingClientRect();
        e.top > 0 && (D = e.top), e.left > 0 && (y = e.left), e.right < k && (k = e.right), e.bottom < b && (b = e.bottom);
      }
      let v = 0;
      "auto" === f && (o < y ? (f = "left", v = y - o) : o + a > k ? (f = "right", k < c && (v = k - c)) : f = "rtl" === Ve(n) ? c - a < y ? "left" : "right" : "left"), "right" === f && (m += h - a), m += v, "auto" === p && (p = d - r > D && l + r > b ? "top" : "bottom"), "top" === p ? w -= r : w += u, e.remove(...Object.values(Oe)), e.add(Oe[f], Oe[p]), i.left = Se(m), i.top = Se(w);
    }
    setViewSwitchLabel(e) {
      this.controls.viewSwitch.textContent = e;
    }
    setPrevButtonDisabled(e) {
      this.controls.prevButton.disabled = e;
    }
    setNextButtonDisabled(e) {
      this.controls.nextButton.disabled = e;
    }
    changeView(e) {
      const t = this.currentView;
      return e !== t.id && (this._oldView || (this._oldView = t), this.currentView = this.views[e], this._renderMethod = "render"), this;
    }
    changeFocus(e) {
      return this._renderMethod = Fe(this, e) ? "render" : "refreshFocus", this.views.forEach(e => {
        e.updateFocus();
      }), this;
    }
    update(e = void 0) {
      const t = void 0 === e ? Ce(this.datepicker) : e;
      return this._renderMethod = Fe(this, t) ? "render" : "refresh", this.views.forEach(e => {
        e.updateFocus(), e.updateSelection();
      }), this;
    }
    render(e = !0) {
      const {
          currentView: t,
          datepicker: i,
          _oldView: s
        } = this,
        n = new Date(this._oldViewDate),
        a = e && this._renderMethod || "render";
      if (delete this._oldView, delete this._oldViewDate, delete this._renderMethod, t[a](), s && (this.main.replaceChild(t.element, s.element), fe(i, "changeView")), !isNaN(n)) {
        const e = new Date(this.viewDate);
        e.getFullYear() !== n.getFullYear() && fe(i, "changeYear"), e.getMonth() !== n.getMonth() && fe(i, "changeMonth");
      }
    }
  }
  function Ae(e, t, i, n, a, r) {
    if (s(e, a, r)) {
      if (n(e)) {
        return Ae(t(e, i), t, i, n, a, r);
      }
      return e;
    }
  }
  function Le(e, t, i) {
    const s = e.picker,
      n = s.currentView,
      a = n.step || 1;
    let r,
      o = s.viewDate;
    switch (n.id) {
      case 0:
        o = l(o, i ? 7 * t : t), r = l;
        break;
      case 1:
        o = h(o, i ? 4 * t : t), r = h;
        break;
      default:
        o = u(o, t * (i ? 4 : 1) * a), r = u;
    }
    o = Ae(o, r, t < 0 ? -a : a, e => n.disabled.includes(e), n.minDate, n.maxDate), void 0 !== o && s.changeFocus(o).render();
  }
  function Ye(e, t) {
    const {
        config: i,
        picker: s,
        editMode: n
      } = e,
      a = s.active,
      {
        key: r,
        altKey: o,
        shiftKey: d
      } = t,
      c = t.ctrlKey || t.metaKey,
      l = () => {
        t.preventDefault(), t.stopPropagation();
      };
    if ("Tab" === r) return void ye(e);
    if ("Enter" === r) {
      if (a) {
        if (n) e.exitEditMode({
          update: !0,
          autohide: i.autohide
        });else {
          const t = s.currentView;
          t.isMinView ? e.setDate(s.viewDate) : (s.changeView(t.id - 1).render(), l());
        }
      } else e.update();
      return;
    }
    const h = i.shortcutKeys,
      u = {
        key: r,
        ctrlOrMetaKey: c,
        altKey: o,
        shiftKey: d
      },
      f = Object.keys(h).find(e => {
        const t = h[e];
        return !Object.keys(t).find(e => t[e] !== u[e]);
      });
    if (f) {
      let t;
      if ("toggle" === f ? t = f : n ? "exitEditMode" === f && (t = f) : a ? "hide" === f ? t = f : "prevButton" === f ? t = [pe, [e, -1]] : "nextButton" === f ? t = [pe, [e, 1]] : "viewSwitch" === f ? t = [me, [e]] : i.clearButton && "clearButton" === f ? t = [we, [e]] : i.todayButton && "todayButton" === f && (t = [ge, [e]]) : "show" === f && (t = f), t) return Array.isArray(t) ? t[0].apply(null, t[1]) : e[t](), void l();
    }
    if (!a || n) return;
    const p = (i, s) => {
      d || c || o ? e.enterEditMode() : (Le(e, i, s), t.preventDefault());
    };
    "ArrowLeft" === r ? p(-1, !1) : "ArrowRight" === r ? p(1, !1) : "ArrowUp" === r ? p(-1, !0) : "ArrowDown" === r ? p(1, !0) : ("Backspace" === r || "Delete" === r || r && 1 === r.length && !c) && e.enterEditMode();
  }
  function We(e) {
    e.config.showOnFocus && !e._showing && e.show();
  }
  function _e(e, t) {
    const i = t.target;
    (e.picker.active || e.config.showOnClick) && (i._active = Y(i), i._clicking = setTimeout(() => {
      delete i._active, delete i._clicking;
    }, 2e3));
  }
  function Ke(e, t) {
    const i = t.target;
    i._clicking && (clearTimeout(i._clicking), delete i._clicking, i._active && e.enterEditMode(), delete i._active, e.config.showOnClick && e.show());
  }
  function Re(e, t) {
    t.clipboardData.types.includes("text/plain") && e.enterEditMode();
  }
  function je(e, t) {
    const {
      element: i,
      picker: s
    } = e;
    if (!s.active && !Y(i)) return;
    const n = s.element;
    P(t, e => e === i || e === n) || ye(e);
  }
  function Te(e, t) {
    return e.map(e => B(e, t.format, t.locale)).join(t.dateDelimiter);
  }
  function He(e, t, i = !1) {
    if (0 === t.length) return i ? [] : void 0;
    const {
        config: n,
        dates: a,
        rangeSideIndex: r
      } = e,
      {
        pickLevel: o,
        maxNumberOfDates: d
      } = n;
    let c = t.reduce((e, t) => {
      let i = V(t, n.format, n.locale);
      return void 0 === i || (i = b(i, o, r), !s(i, n.minDate, n.maxDate) || e.includes(i) || n.checkDisabled(i, o) || !(o > 0) && n.daysOfWeekDisabled.includes(new Date(i).getDay()) || e.push(i)), e;
    }, []);
    return 0 !== c.length ? (n.multidate && !i && (c = c.reduce((e, t) => (a.includes(t) || e.push(t), e), a.filter(e => !c.includes(e)))), d && c.length > d ? c.slice(-1 * d) : c) : void 0;
  }
  function Ie(e, t = 3, i = !0, s = void 0) {
    const {
      config: n,
      picker: a,
      inputField: r
    } = e;
    if (2 & t) {
      const e = a.active ? n.pickLevel : n.startView;
      a.update(s).changeView(e).render(i);
    }
    1 & t && r && (r.value = Te(e.dates, n));
  }
  function $e(e, t, i) {
    const s = e.config;
    let {
      clear: n,
      render: a,
      autohide: r,
      revert: o,
      forceRefresh: d,
      viewDate: c
    } = i;
    void 0 === a && (a = !0), a ? void 0 === r && (r = s.autohide) : r = d = !1, c = V(c, s.format, s.locale);
    const l = He(e, t, n);
    (l || o) && (l && l.toString() !== e.dates.toString() ? (e.dates = l, Ie(e, a ? 3 : 1, !0, c), fe(e, "changeDate")) : Ie(e, d ? 3 : 1, !0, c), r && e.hide());
  }
  function Pe(e, t) {
    return t ? i => B(i, t, e.config.locale) : e => new Date(e);
  }
  class Je {
    constructor(e, t = {}, s = void 0) {
      e.datepicker = this, this.element = e, this.dates = [];
      const n = this.config = Object.assign({
        buttonClass: t.buttonClass && String(t.buttonClass) || "button",
        container: null,
        defaultViewDate: d(),
        maxDate: void 0,
        minDate: void 0
      }, se(U, this));
      let a;
      if ("INPUT" === e.tagName ? (a = this.inputField = e, a.classList.add("datepicker-input"), t.container && (n.container = t.container instanceof HTMLElement ? t.container : document.querySelector(t.container))) : n.container = e, s) {
        const e = s.inputs.indexOf(a),
          t = s.datepickers;
        if (e < 0 || e > 1 || !Array.isArray(t)) throw Error("Invalid rangepicker object.");
        t[e] = this, this.rangepicker = s, this.rangeSideIndex = e;
      }
      this._options = t, Object.assign(n, se(t, this)), n.shortcutKeys = function (e) {
        return Object.keys(ne).reduce((t, i) => {
          const s = void 0 === e[i] ? ne[i] : e[i],
            n = s && s.key;
          if (!n || "string" != typeof n) return t;
          const a = {
            key: n,
            ctrlOrMetaKey: !!(s.ctrlOrMetaKey || s.ctrlKey || s.metaKey)
          };
          return n.length > 1 && (a.altKey = !!s.altKey, a.shiftKey = !!s.shiftKey), t[i] = a, t;
        }, {});
      }(t.shortcutKeys || {});
      const r = i(e.value || e.dataset.date, n.dateDelimiter);
      delete e.dataset.date;
      const o = He(this, r);
      o && o.length > 0 && (this.dates = o), a && (a.value = Te(this.dates, n));
      const c = this.picker = new Ee(this),
        l = [e, "keydown", Ye.bind(null, this)];
      a ? H(this, [l, [a, "focus", We.bind(null, this)], [a, "mousedown", _e.bind(null, this)], [a, "click", Ke.bind(null, this)], [a, "paste", Re.bind(null, this)], [document, "mousedown", je.bind(null, this)], [window, "resize", c.place.bind(c)]]) : (H(this, [l]), this.show());
    }
    static formatDate(e, t, i) {
      return B(e, t, i && J[i] || J.en);
    }
    static parseDate(e, t, i) {
      return V(e, t, i && J[i] || J.en);
    }
    static get locales() {
      return J;
    }
    get active() {
      return !(!this.picker || !this.picker.active);
    }
    get pickerElement() {
      return this.picker ? this.picker.element : void 0;
    }
    setOptions(e) {
      const t = se(e, this);
      Object.assign(this._options, e), Object.assign(this.config, t), this.picker.setOptions(t), Ie(this, 3);
    }
    show() {
      if (this.inputField) {
        const {
          config: e,
          inputField: t
        } = this;
        if (t.disabled || t.readOnly && !e.enableOnReadonly) return;
        Y(t) || e.disableTouchKeyboard || (this._showing = !0, t.focus(), delete this._showing);
      }
      this.picker.show();
    }
    hide() {
      this.inputField && (this.picker.hide(), this.picker.update().changeView(this.config.startView).render());
    }
    toggle() {
      this.picker.active ? this.inputField && this.picker.hide() : this.show();
    }
    destroy() {
      this.hide(), I(this), this.picker.detach();
      const e = this.element;
      return e.classList.remove("datepicker-input"), delete e.datepicker, this;
    }
    getDate(e = void 0) {
      const t = Pe(this, e);
      return this.config.multidate ? this.dates.map(t) : this.dates.length > 0 ? t(this.dates[0]) : void 0;
    }
    setDate(...t) {
      const i = [...t],
        s = {},
        n = e(t);
      !n || "object" != typeof n || Array.isArray(n) || n instanceof Date || Object.assign(s, i.pop());
      $e(this, Array.isArray(i[0]) ? i[0] : i, s);
    }
    update(e = void 0) {
      if (!this.inputField) return;
      const t = Object.assign(e || {}, {
        clear: !0,
        render: !0,
        viewDate: void 0
      });
      $e(this, i(this.inputField.value, this.config.dateDelimiter), t);
    }
    getFocusedDate(e = void 0) {
      return Pe(this, e)(this.picker.viewDate);
    }
    setFocusedDate(e, t = !1) {
      const {
          config: i,
          picker: s,
          active: n,
          rangeSideIndex: a
        } = this,
        r = i.pickLevel,
        o = V(e, i.format, i.locale);
      void 0 !== o && (s.changeFocus(b(o, r, a)), n && t && s.changeView(r), s.render());
    }
    refresh(e = void 0, t = !1) {
      let i;
      e && "string" != typeof e && (t = e, e = void 0), i = "picker" === e ? 2 : "input" === e ? 1 : 3, Ie(this, i, !t);
    }
    enterEditMode() {
      const e = this.inputField;
      e && !e.readOnly && this.picker.active && !this.editMode && (this.editMode = !0, e.classList.add("in-edit"));
    }
    exitEditMode(e = void 0) {
      if (!this.inputField || !this.editMode) return;
      const t = Object.assign({
        update: !1
      }, e);
      delete this.editMode, this.inputField.classList.remove("in-edit"), t.update && this.update(t);
    }
  }
  function Ue(e) {
    const t = Object.assign({}, e);
    return delete t.inputs, delete t.allowOneSidedRange, delete t.maxNumberOfDates, t;
  }
  function qe(e, t) {
    if (e._updating) return;
    e._updating = !0;
    const i = t.target;
    if (void 0 === i.datepicker) return;
    const s = e.datepickers,
      [n, a] = s,
      r = {
        render: !1
      },
      o = e.inputs.indexOf(i),
      d = 0 === o ? 1 : 0,
      c = s[o].dates[0],
      l = s[d].dates[0];
    void 0 !== c && void 0 !== l ? 0 === o && c > l ? (n.setDate(l, r), a.setDate(c, r)) : 1 === o && c < l && (n.setDate(c, r), a.setDate(l, r)) : e.allowOneSidedRange || void 0 === c && void 0 === l || (r.clear = !0, s[d].setDate(s[o].dates, r)), s.forEach(e => {
      e.picker.update().render();
    }), delete e._updating;
  }
  window.Datepicker = Je, window.DateRangePicker = class {
    constructor(e, t = {}) {
      let i = Array.isArray(t.inputs) ? t.inputs : Array.from(e.querySelectorAll("input"));
      if (i.length < 2) return;
      e.rangepicker = this, this.element = e, this.inputs = i = i.slice(0, 2), Object.freeze(i), this.allowOneSidedRange = !!t.allowOneSidedRange;
      const s = qe.bind(null, this),
        n = Ue(t),
        a = this.datepickers = [];
      i.forEach(e => {
        !function (e, t, i, s) {
          H(e, [[i, "changeDate", t]]), new Je(i, s, e);
        }(this, s, e, n);
      }), Object.freeze(a), Object.defineProperty(this, "dates", {
        get: () => a.map(e => e.dates[0])
      }), a[0].dates.length > 0 ? qe(this, {
        target: i[0]
      }) : a[1].dates.length > 0 && qe(this, {
        target: i[1]
      });
    }
    setOptions(e) {
      this.allowOneSidedRange = !!e.allowOneSidedRange;
      const t = Ue(e);
      this.datepickers.forEach(e => {
        e.setOptions(t);
      });
    }
    destroy() {
      this.datepickers.forEach(e => {
        e.destroy();
      }), I(this), delete this.element.rangepicker;
    }
    getDates(e = void 0) {
      const t = e ? t => B(t, e, this.datepickers[0].config.locale) : e => new Date(e);
      return this.dates.map(e => void 0 === e ? e : t(e));
    }
    setDates(e, t) {
      const {
        datepickers: [i, s],
        inputs: [n, a],
        dates: [r, o]
      } = this;
      this._updating = !0, i.setDate(e), s.setDate(t), delete this._updating, s.dates[0] !== o ? qe(this, {
        target: a
      }) : i.dates[0] !== r && qe(this, {
        target: n
      });
    }
  };
}();
/******/ })()
;