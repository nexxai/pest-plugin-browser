1.	Initial Setup
•	Scan the entire project before starting.
•	Understand the project’s structure and coding conventions.
2.	Tooling
•	Read and respect all tools and dependencies defined in composer.json.
•	Use configured tools as expected (e.g., PHPStan, Rector, Pest, etc.).
3.	PHP Standards
•	Use PHP 8.4 syntax and features.
•	Follow strict typing everywhere: scalar types, return types, property types.
•	Enforce strict array shapes — no untyped or loose arrays.
4.	Code Quality
•	Stick to existing naming, formatting, and architectural patterns.
•	No commented-out code.
•	Avoid magic strings and numbers.
•	Keep functions and classes short, focused, and testable.
5.	Testing
•	When modifying code, run only the relevant portion of the test suite.
•	Before finishing, run composer test to ensure full suite passes.
6.	Commits & Messages
•	Keep commits atomic and messages clear (e.g., fix: correct invoice rounding logic).
•	Do not auto-format unrelated code.
7.	Other
•	Prefer value objects over raw arrays where it makes sense.
•	Avoid unnecessary abstractions — keep it simple and pragmatic.
•	Never leave TODOs or FIXMEs without context or a follow-up issue.
