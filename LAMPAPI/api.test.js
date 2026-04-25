/* global test, expect */

const BASE_URL = process.env.API_BASE_URL || "http://127.0.0.1:8000/LAMPAPI";

async function postJson(endpoint, body) {
  const response = await fetch(`${BASE_URL}/${endpoint}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(body)
  });

  const text = await response.text();

  return {
    response,
    text,
    data: JSON.parse(text)
  };
}

test("integration: Login.php returns valid JSON for a real user", async () => {
  const { response, data } = await postJson("Login.php", {
    login: "testuser",
    password: "testpass"
  });

  expect(response.status).toBe(200);

  expect(data).toHaveProperty("id");
  expect(data).toHaveProperty("firstName");
  expect(data).toHaveProperty("lastName");
  expect(data).toHaveProperty("error");

  expect(data.error).toBe("");
  expect(data.id).toBeGreaterThan(0);
  expect(data.firstName).toBe("Test");
});

test("integration: SearchColors.php returns seeded colors for the logged in user", async () => {
  const loginResult = await postJson("Login.php", {
    login: "testuser",
    password: "testpass"
  });

  const { response, data } = await postJson("SearchColors.php", {
    search: "Bl",
    userId: loginResult.data.id
  });

  expect(response.status).toBe(200);
  expect(data.error).toBe("");
  expect(data.results).toContain("Blue");
});

test("integration: AddColor.php persists a color that can be searched", async () => {
  const loginResult = await postJson("Login.php", {
    login: "testuser",
    password: "testpass"
  });

  const addedColor = "Green";
  const addResult = await postJson("AddColor.php", {
    color: addedColor,
    userId: loginResult.data.id
  });

  expect(addResult.response.status).toBe(200);
  expect(addResult.data.error).toBe("");

  const searchResult = await postJson("SearchColors.php", {
    search: addedColor,
    userId: loginResult.data.id
  });

  expect(searchResult.response.status).toBe(200);
  expect(searchResult.data.error).toBe("");
  expect(searchResult.data.results).toContain(addedColor);
});
