# Laravel Task API (To-Do List)

## Версии
- **Composer:** 2.8.10
- **Laravel Framework:** 12.36.1
- **Postman:** `⎨ task.postman_collection.json ⎬`

---

## Роутинг

**Service Provider:** `App\Providers\RouteServiceProvider`

**API V1:**

| Метод | URL | Описание |
|-------|-----|----------|
| GET   | `/v_1/tasks` | Получить весь список задач |
| GET   | `/v_1/tasks/{id}` | Получить одну задачу |
| POST  | `/v_1/tasks` | Создать задачу |
| PUT   | `/v_1/tasks/{id}` | Обновить задачу |
| DELETE| `/v_1/tasks/{id}` | Удалить задачу |

---

## Контроллеры

**Namespace:** `App\Http\Controllers\Api\V_1\Task`

| Контроллер | Метод |
|------------|-------|
| `IndexController` | `__invoke()` |
| `ShowController` | `__invoke($id)` |
| `StoreController` | `__invoke(StoreRequest $request)` |
| `UpdateController` | `__invoke(UpdateRequest $request, $id)` |
| `DestroyController` | `__invoke($id)` |

---

## Тесты (Feature)

**Namespace:** `Tests\Feature\Api\V_1\Task`

| Тест | Описание |
|------|----------|
| `IndexTest` | Проверка получения списка задач |
| `ShowTest` | Проверка получения одной задачи |
| `StoreTest` | Проверка создания задачи |
| `UpdateTest` | Проверка обновления задачи |
| `DestroyTest` | Проверка удаления задачи |

---

## Интерфейсы

**Namespace:** `App\Contracts\Task`

- `TaskServiceContract` – контракт для работы с задачами

---

## Сервисы

**Namespace:** `App\Services\Task`

- `TaskService` – реализация логики работы с задачами

**Binding Service & Interface:** `App\Providers\ServiceBindingProvider`

---

## Facades

**Namespace:** `App\Facades\Task`

- `TaskFacade` – фасад для удобного обращения к сервису

**Binding Service & Facade:** `App\Providers\FacadeServiceProvider`

---

## Actions

**Namespace:** `App\Actions\Task`

| Action | Описание |
|--------|----------|
| `StoreAction` | Логика создания задачи |
| `UpdateAction` | Логика обновления задачи |
| `DeleteAction` | Логика удаления задачи |


