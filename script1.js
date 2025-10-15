async function registerUser() {
  const username = document.getElementById("reg_username").value;
  const password = document.getElementById("reg_password").value;
  const role = document.getElementById("role").value;

  const response = await fetch("/api/register", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, password, role })
  });

  const data = await response.json();
  alert(data.message || data.error);
}

async function login() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const response = await fetch("/api/login", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, password })
  });

  const data = await response.json();
  if (data.error) {
    alert(data.error);
  } else {
    alert(`Welcome ${username}! Role: ${data.role}`);
  }
}

