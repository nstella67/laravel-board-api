# Laravel Board API

게시판 API 개발 프로젝트  
게시글(Post)과 댓글(Comment)의 CRUD 기능을 제공합니다.  

---

## 1. 프로젝트 개요

- **프레임워크**: Laravel 10  
- **언어**: PHP 8.2  
- **데이터베이스**: MySQL 8.0  
- **실행환경**: Docker + Docker Compose  
- **주요 기능**
  - 게시글 CRUD (제목, 내용, 작성자, 작성일)
  - 댓글 CRUD (특정 게시글에 대한 댓글)
  - 페이지네이션
  - 요청 데이터 유효성 검사
  - 공통 JSON 응답 포맷
 
- **프로젝트 구조**
```
laravel-board-api/
├── docker/                                         # Docker 관련 설정
│   ├── Dockerfile                                  # PHP-FPM + Composer 환경 정의
│   └── default.conf                                # Nginx 설정파일
├── src/                                            # Laravel App
│   ├── app/Http/Controllers                        # 컨트롤러 (PostController, CommentController)
│   ├── app/Models                                  # 모델 (Post, Comment)
│   ├── database/migrations                         # 마이그레이션 파일 (테이블 구조 정의)
│   ├── database/seeders                            # 시더 파일 (더미 데이터 생성)
│   ├── routes/api.php                              # API 라우트 정의 (posts, comments)
│   └── ...
├── docker-compose.yml                              # Docker 서비스 정의 (app, nginx, mysql)
├── laravel-board-api.postman_collection.json       # Postman Collection
└── README.md
```

---

## 2. 설치 및 실행 방법

### (1) 프로젝트 클론
```bash
git clone https://github.com/your-username/laravel-board-api.git
cd laravel-board-api
```

### (2) 환경 설정
```bash
cp src/.env.example src/.env
```
`.env` 파일에서 DB 접속 정보 등을 필요에 맞게 수정합니다.  

### (3) Docker 컨테이너 실행
```bash
docker-compose up -d --build
```

### (4) Composer 의존성 설치
```bash
docker exec -it laravel_app composer install
```

### (5) 애플리케이션 키 생성
```bash
docker exec -it laravel_app php artisan key:generate
```

### (6) 마이그레이션 및 시더 실행
```bash
docker exec -it laravel_app php artisan migrate --seed
```

---

## 3. API 엔드포인트

### 게시글(Post)
- **POST** `/api/posts` : 게시글 생성  
- **GET** `/api/posts` : 게시글 목록 (페이지네이션 지원, `?per_page=` 파라미터 가능)  
- **GET** `/api/posts/{id}` : 게시글 상세조회  
- **PUT** `/api/posts/{id}` : 게시글 수정  
- **DELETE** `/api/posts/{id}` : 게시글 삭제  

### 댓글(Comment)
- **GET** `/api/posts/{post}/comments` : 특정 게시글의 댓글 목록  
- **POST** `/api/posts/{post}/comments` : 댓글 생성  
- **PUT** `/api/posts/{post}/comments/{id}` : 댓글 수정  
- **DELETE** `/api/posts/{post}/comments/{id}` : 댓글 삭제  

---

## 4. Postman Collection

`laravel-board-api.postman_collection.json` 파일을 Postman에 Import 하여 API 테스트가 가능합니다.  
총 9개의 요청이 포함되어 있습니다.  

---

## 5. 예시 응답 (게시글 목록)

```json
{
  "success": true,
  "message": "Post list retrieved successfully",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "테스트 글 1",
        "content": "본문입니다",
        "author": "이누리",
        "created_at": "2025-08-22T10:06:52.000000Z",
        "updated_at": "2025-08-22T10:06:52.000000Z"
      }
    ],
    "first_page_url": "http://localhost:8000/api/posts?page=1",
    "last_page": 1,
    "per_page": 10,
    "total": 1
  }
}
```

---

## 6. 개발자 가이드

- **라우트 확인**
```bash
docker exec -it laravel_app php artisan route:list
```

- **캐시 초기화**
```bash
docker exec -it laravel_app php artisan route:clear
docker exec -it laravel_app php artisan config:clear
docker exec -it laravel_app php artisan cache:clear
```

---

