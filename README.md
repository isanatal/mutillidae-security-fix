# 🔒 Mutillidae Security Fix Project

## 📋 Project Overview
This project demonstrates the remediation of critical security vulnerabilities in a deliberately vulnerable web application (Mutillidae) as part of a security audit and remediation exercise.

## 🛡️ Vulnerabilities Corrected

| ID | Vulnerability | OWASP Category | Fix Applied |
|----|---------------|----------------|-------------|
| 01 | SQL Injection (Bypass Authentication) | A1:2021 - Injection | Prepared Statements (PDO) |
| 02 | SQL Injection (Union-Based) | A1:2021 - Injection | Parameterized Queries |
| 03 | Reflected XSS | A3:2021 - Cross-Site Scripting | htmlspecialchars() Output Encoding |
| 04 | Stored XSS (Persistent) | A3:2021 - Cross-Site Scripting | Sanitization + Output Encoding |
| 05 | HTML/JavaScript Injection | A3:2021 - Cross-Site Scripting | Input Validation + Output Encoding |

## 📁 Project Structure