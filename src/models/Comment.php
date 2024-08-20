<?php

namespace Ferre\Comments\Models;

use Ferre\Comments\Models\Database;

class Comment extends Database
{

    private string $uuid;
    private string $date;

    public function __construct(private string $username, private string $text, private string $url)
    {
        parent::__construct();
        $this->uuid = uniqid();
    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO comments (uuid, username, text, url, date)  VALUES (:uuid, :username, :text, :url, NOW())");

        $query->execute(["uuid" => $this->uuid, "username" => $this->username, "text" => $this->text, "url" => $this->url]);
    }

    public static function getAll(string $url): array | null
    {
        $data = [];
        $db = new Database();

        $query = $db->connect()->prepare("SELECT * FROM comments WHERE url = :url");
        $query->execute(["url" => $url]);

        if ($query->rowCount() <= 0) {
            return null;
        }

        while ($result = $query->fetch()) {
            $data[] = Comment::createFromArray($result);
        }

        return $data;

    }

    public static function createFromArray(array $data): Comment
    {
        $comment = new Comment($data["username"], $data["text"], $data["url"]);

        $comment->setUUID($data["uuid"]);
        $comment->setDate($data["date"]);

        return $comment;
    }

    public function setUUID(string $value): void
    {
        $this->uuid = $value;
    }

    public function setDate(string $value): void
    {
        $this->date = $value;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDate(): string
    {
        return $this->date;
    }

}
