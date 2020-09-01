S3-PowerfulBackup
=================

Turns your S3 storage into a professional backup server with access control, read-write policies and files rotation.

**Features:**
- Multi-user with permissions management
- Fixed limits on filesize, mimetype
- Transactional backups (example: "Website" consists of two backups: DB backup + File uploads backup)
- Direct access via S3 interface to buckets created by S3-PowerfulBackup
- High security by using policies and UUIDs

Store mechanism
---------------

1. User creates backup, and optionally a backup sequence (sequence connects multiple backups to version together eg. DB + file uploads = 1 application full backup)
2. A client is uploading backups to S3 to a write-only bucket, where the backup is getting queued
3. Background processing node is validating the uploaded file, renaming it, assigning a version and moving to a read-only bucket
4. The S3-PowerfulBackup backend retrieves internal API calls from Background processing node to finalize transaction, set metadata, full filesize, mimetyp fields
5. Backup retrieves a ready status

Developers
==========

Project is split into domains - `Backup`, `Users`, `Security`, `Storage`.
Each domain is communicating to each other by emitting events via Event Bus.

The project has `hexagonal architecture` - Domain, Application, Infrastructure.

**Structure - examples:**

```yaml
src/Application # Command-bus handlers and commands
src/Controller  # HTTP layer
src/Domain/Users/View         # models used only for viewing (returned by queries), does not contain validations, just a DTO (already validated by write layer)
src/Domain/Users/WriteModel   # models used to write to database (used by commands), contains domain-specific logic and validations
```
