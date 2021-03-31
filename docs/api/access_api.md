<!--- -------------------------------------------------------------------------------------------------------------- -->

### `{ POST /*/ban-user }`

Used to ban an user from chat and remove all user's messages from the chat.

### Permissions

- Must be logged in
- Must have the 'chat.ban_user' permission

### Request Parameters

|Type|Key|Required|Default|Options|Notes|
|----|---|--------|-------|-------|-----|
|body|user_id|yes|||The user id to ban|

### Validation Rules

```php
[
    'user_id' => 'required',
];
```

### Request Example

```js   
$.ajax({
    url: 'https://www.drumeo.com' +
        '/chat/ban-user',
    type: 'post',
    data: {
        user_id: '128762'
    }, 
    success: function(response) {},
    error: function(response) {}
});
```

### Response Example

**
NOTES:
- response is empty for successful operation
- errors are returned into an array
**

```200 OK```

```json
[]
```

```422 request validation failed```

```json
[
  {
    "title": "Validation failed.",
    "source": "user_id",
    "detail": "The user id field is required."
  }
]
```

```404 getstream API call returned an user not found error response```

```json
[
  {
    "title": "Not found.",
    "detail": "StreamChat could not find specified user"
  }
]
```

```503 getstream API call returned an error response```

```json
[
  {
    "title": "StreamChat Exception",
    "detail": "StreamChat exception occured while trying to ban user"
  }
]
```

```500```

```json
[
  {
    "title": "Railchat Exception",
    "detail": "Exception occured while trying to ban user"
  }
]
```

<!--- -------------------------------------------------------------------------------------------------------------- -->

### `{ POST /*/unban-user }`

Used to unban an user from chat.

### Permissions

- Must be logged in
- Must have the 'chat.unban_user' permission

### Request Parameters

|Type|Key|Required|Default|Options|Notes|
|----|---|--------|-------|-------|-----|
|body|user_id|yes|||The user id to unban|

### Validation Rules

```php
[
    'user_id' => 'required',
];
```

### Request Example

```js   
$.ajax({
    url: 'https://www.drumeo.com' +
        '/chat/unban-user',
    type: 'post',
    data: {
        user_id: '128762'
    }, 
    success: function(response) {},
    error: function(response) {}
});
```

### Response Example

**
NOTES:
- response is empty for successful operation
- errors are returned into an array
**

```200 OK```

```json
[]
```

```422 request validation failed```

```json
[
  {
    "title": "Validation failed.",
    "source": "user_id",
    "detail": "The user id field is required."
  }
]
```

```404 getstream API call returned an user not found error response```

```json
[
  {
    "title": "Not found.",
    "detail": "StreamChat could not find specified user"
  }
]
```

```503 getstream API call returned an error response```

```json
[
  {
    "title": "StreamChat Exception",
    "detail": "StreamChat exception occured while trying to unban user"
  }
]
```

```500```

```json
[
  {
    "title": "Railchat Exception",
    "detail": "Exception occured while trying to unban user"
  }
]
```

<!--- -------------------------------------------------------------------------------------------------------------- -->

### `{ POST /*/delete-user-messages }`

Used to delete all user messages from chat

### Permissions

- Must be logged in
- Must have the 'chat.delete_user_messages' permission

### Request Parameters

|Type|Key|Required|Default|Options|Notes|
|----|---|--------|-------|-------|-----|
|body|user_id|yes|||The user id to delete all messages|

### Validation Rules

```php
[
    'user_id' => 'required',
];
```

### Request Example

```js   
$.ajax({
    url: 'https://www.drumeo.com' +
        '/chat/delete-user-messages',
    type: 'post',
    data: {
        user_id: '128762'
    }, 
    success: function(response) {},
    error: function(response) {}
});
```

### Response Example

**
NOTES:
- response is empty for successful operation
- errors are returned into an array
**

```200 OK```

```json
[]
```

```422 request validation failed```

```json
[
  {
    "title": "Validation failed.",
    "source": "user_id",
    "detail": "The user id field is required."
  }
]
```

```404 getstream API call returned an user not found error response```

```json
[
  {
    "title": "Not found.",
    "detail": "StreamChat could not find specified user"
  }
]
```

```503 getstream API call returned an error response```

```json
[
  {
    "title": "StreamChat Exception",
    "detail": "StreamChat exception occured while trying to remove user messages"
  }
]
```

```500```

```json
[
  {
    "title": "Railchat Exception",
    "detail": "Exception occured while trying to remove user messages"
  }
]
```