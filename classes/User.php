<?php
require_once BASE_PATH . '/classes/BaseModel.php';

class User extends BaseModel
{
    protected string $table = 'users';

    private ?int $id = null;
    private string $username = '';
    private string $email = '';
    private string $role = 'buyer';
    private ?string $address = null;
    private ?string $phone = null;

    
    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }
    public function getAddress(): ?string { return $this->address; }
    public function getPhone(): ?string { return $this->phone; }

    
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setRole(string $role): void { $this->role = $role; }
    public function setAddress(?string $address): void { $this->address = $address; }
    public function setPhone(?string $phone): void { $this->phone = $phone; }

    

    public function hydrate(array $data): self
    {
        $this->id       = (int) $data['id'];
        $this->username = $data['username'];
        $this->email    = $data['email'];
        $this->role     = $data['role'];
        $this->address  = $data['address'] ?? null;
        $this->phone    = $data['phone'] ?? null;
        return $this;
    }

    

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    

    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    

    public function register(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->create($data);
    }

    

    public function getSellers(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE role = 'seller'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
