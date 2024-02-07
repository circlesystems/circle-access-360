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
- Update ```ajax/constants.php``` with your appKey, write and read keys. You can request one on www.circlesecurity.ai
- Update ```index.html``` (end of the file) with your appKey
- Circle Access authentication module included in the project

### Installation
1. Clone the repository to your server.
2. Ensure `callback.php` is accessible to handle authentication callbacks.

### Configuration
- Configure your admin emails within the script to manage access control.
- Use `hashText` function to securely compare user email hashes against admin list.

## Usage
Redirect authentication callbacks to `callback.php` for secure user authentication and session management. The script will provide a secure and efficient authentication flow:

1. **Error Reporting**: Initially, the script enables comprehensive error reporting to aid in debugging during development.

2. **Session Management**: It begins by initiating a session and includes the Circle Access authentication module for handling authentication processes.

3. **User and Session ID Validation**: The script captures `userID` and `sessionID` from the request, validating them to ensure they correspond to a valid user session.

4. **Session and Role Verification**: Through the validation process, it checks if the session is active and if the user's email is listed among the admin emails. This is done securely using SHA-256 hashing for email comparison, illustrating the script's commitment to security.

5. **Secure Redirection**: Depending on the outcome of the email verification, the script redirects users to appropriate dashboards - admin users to an admin dashboard and regular users to a user-specific page. This redirection is preceded by expiring the user's current session to prevent replay attacks, highlighting the script's robust security measures.

6. **Unauthorized Access Handling**: If a user fails the authentication checks, the script displays a message indicating unauthorized access, directing them to retry the login process.

This authentication flow underscores the script's dual focus on security and user experience, ensuring that users are authenticated securely and directed to resources that match their access level.


## Security Practices

In a real-world application, the admin emails used for authentication in ```callback.php``` would typically be stored in a database.
The script would then query this database to retrieve and verify user emails during the authentication process, ensuring a dynamic and secure management of user roles and permissions. This approach allows for scalable and manageable user access control, facilitating session initiation based on validated user credentials directly from the database.

## License
This script is released under the MIT License. See the LICENSE file for more details.
