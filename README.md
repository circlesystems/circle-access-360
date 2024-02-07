# Circle Access 360 PHP Authentication Script

## Overview
This PHP script facilitates secure user authentication by validating sessions and managing user roles within web applications. It ensures that user credentials are properly authenticated and that sessions are securely managed to prevent replay attacks.

## Features
- **Secure Authentication**: Utilizes Circle Access for robust user authentication.
- **Session Validation**: Checks the validity of user sessions to prevent unauthorized access.
- **Role-Based Access Control**: Differentiates user access based on predefined admin email addresses.
- **Secure Session Handling**: Implements measures to expire sessions post-validation to enhance security.

## Getting Started

### Prerequisites
- Circle Access authentication module included in the project

### Installation
1. Clone the repository to your server.
2. Ensure `callback.php` is accessible to handle authentication callbacks.

### Configuration
- Configure your admin emails within the script to manage access control.
- Use `hashText` function to securely compare user email hashes against admin list.

## Usage
Redirect authentication callbacks to `callback.php` for secure user authentication and session management. The script will:
1. Validate the session ID and user ID.
2. Check if the user's email hash matches any in the predefined admin list.
3. Redirect users based on their role after successful authentication.

## Security Practices
Ensure all traffic is served over HTTPS to protect sensitive information during transmission.

## Contributing
Contributions to enhance the script's functionality or security are welcome. Please submit pull requests or issues through GitHub.

## License
This script is released under the MIT License. See the LICENSE file for more details.
