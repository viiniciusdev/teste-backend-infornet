// auth.js — versão simples com token manual

// COPIE AQUI SEU TOKEN JWT PEGO NO POSTMAN
const token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzUwNzM2NTMyLCJleHAiOjE3NTA3NDAxMzIsIm5iZiI6MTc1MDczNjUzMiwianRpIjoiVlpRRE5QcHEwWEc5cFkzQyIsInN1YiI6IjEiLCJwcnYiOiI1ODcwODYzZDRhNjJkNzkxNDQzZmFmOTM2ZmMzNjgwMzFkMTEwYzRmIn0.VV5g3_cSbB8lk8gzmKdbazA3ijUtPoGlr8H5yLVqN_k";

function fetchComToken(url, options = {}) {
  options.headers = {
    ...(options.headers || {}),
    "Authorization": token,
    "Content-Type": "application/json",
    "Accept": "application/json"
  };
  return fetch(url, options);
}
