/* global test, expect */

const BASE_URL = "http://127.0.0.1:8000/LAMPAPI";

test("integration: Login.php returns valid JSON for a real user", async () => {
  const response = await fetch(`${BASE_URL}/Login.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      login: "testuser",
      password: "testpass"
    })
  });

  const data = await response.json();

  expect(response.status).toBe(200);
  expect(data).toHaveProperty("id");
  expect(data).toHaveProperty("firstName");
  expect(data).toHaveProperty("lastName");
  expect(data).toHaveProperty("error");

  expect(data.id).toBeGreaterThan(0);
  expect(data.firstName).toBe("Test");
});