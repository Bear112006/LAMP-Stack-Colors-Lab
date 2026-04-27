/**
 * @jest-environment jsdom
 */
/* global test, expect, beforeEach, jest */

const fs = require("fs");
const path = require("path");

const code = fs.readFileSync(path.resolve(__dirname, "./code.js"), "utf8");

beforeEach(() => {
  document.body.innerHTML = `
    <input id="colorText" value="Blue" />
    <span id="colorAddResult"></span>

    <input id="searchText" value="Bl" />
    <span id="colorSearchResult"></span>
    <p id="colorList"></p>
  `;

  global.XMLHttpRequest = jest.fn(() => ({
    open: jest.fn(),
    setRequestHeader: jest.fn(),
    send: jest.fn(function () {
      this.readyState = 4;
      this.status = 200;
      this.responseText = JSON.stringify({
        results: ["Blue", "Black"],
        error: ""
      });
      this.onreadystatechange();
    })
  }));

  const script = document.createElement("script");
  script.textContent = `
    (() => {
      ${code}
      window.doLogin = doLogin;
      window.saveCookie = saveCookie;
      window.readCookie = readCookie;
      window.doLogout = doLogout;
      window.addColor = addColor;
      window.searchColor = searchColor;
    })();
  `;
  document.body.appendChild(script);
  script.remove();
});

test("unit: addColor sends the typed color and shows success message", () => {
  window.addColor();

  expect(document.getElementById("colorAddResult").innerHTML)
    .toBe("Color has been added");
});

test("integration: searchColor parses API JSON and displays returned colors", () => {
  window.searchColor();

  expect(document.getElementById("colorSearchResult").innerHTML)
    .toBe("Color(s) has been retrieved");

  expect(document.getElementsByTagName("p")[0].innerHTML).toContain("Blue");
  expect(document.getElementsByTagName("p")[0].innerHTML).toContain("Black");
});
