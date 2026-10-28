# TECH-LUNCH

Sistema web de pedidos del cafetín **Astrid Catering** (Tecsup Ate). Permite a los estudiantes, docentes y personal de Tecsup ver el menú, hacer pedidos, pagar con Yape o Plin y recoger su comida en el cafetín o recibirla en su aula, sin hacer cola.

Proyecto del curso **Desarrollo de Aplicaciones en Internet** (3 C24), Tecsup, ciclo 2026-II.

## Grupo 1

| Integrante |
|---|
| Morales Lecca, Fabrizio |
| Silva Silva, Ingrid |
| Valcarcel Cabia, Lucy |
| Zumaran Palomino, Gabriel |

## Tecnologías

- PHP 8.3 o superior
- Laravel 13
- MySQL (más adelante; por ahora SQLite)
- Vite
- Git y GitHub

---

# Guía para el grupo

Sigue estos pasos **una sola vez** en tu laptop. Todos los comandos se escriben en la terminal de Visual Studio Code (*Terminal → New Terminal*).

> En los recuadros, escribe solo el comando. El texto `PS C:\...>` que aparece en la terminal **no se escribe**: solo indica en qué carpeta estás.

## Paso 1. Revisar los programas

Escribe uno por uno:

```
php -v
composer -V
node -v
npm -v
git --version
```

Debe salir la versión de cada uno. PHP debe ser **8.3 o más**.

Si `git` da error, instálalo con este comando, acepta con `Y` y luego **cierra y vuelve a abrir VS Code**:

```
winget install --id Git.Git -e --source winget
```

Si falta PHP, Composer o Node.js, revisa la guía del **Laboratorio 08**.

## Paso 2. Configurar Git (solo la primera vez)

Usa tu nombre y **el mismo correo de tu cuenta de GitHub**:

```
git config --global user.name "Tu Nombre"
git config --global user.email "tu-correo@ejemplo.com"
git config --global init.defaultBranch main
git config --global core.autocrlf true
```

Para revisar:

```
git config --global --list
```

## Paso 3. Crear tu llave SSH y registrarla en GitHub

La llave SSH conecta tu laptop con tu cuenta de GitHub.

1. Crea la llave (cambia el correo por el tuyo):

   ```
   ssh-keygen -t ed25519 -C "tu-correo@ejemplo.com"
   ```

   - En `Enter file in which to save the key` presiona **Enter**.
   - En `Enter passphrase` escribe una contraseña para la llave (no se ve al escribir) o presiona **Enter** para dejarla vacía. **Si pones una, recuérdala**: la pedirá cada vez que subas cambios.

2. Muestra tu llave **pública**:

   ```
   cat ~/.ssh/id_ed25519.pub
   ```

   Copia **solo** la línea que empieza con `ssh-ed25519` y termina con tu correo.

3. En GitHub: foto de perfil → **Settings** → **SSH and GPG keys** → **New SSH key**.
   - **Title:** `Laptop Tu Nombre`
   - **Key:** pega la línea copiada
   - **Add SSH key**

4. Prueba la conexión:

   ```
   ssh -T git@github.com
   ```

   La primera vez escribe `yes`. Debe decir: `Hi tu-usuario! You've successfully authenticated`.

> **Nunca compartas** el archivo `id_ed25519` (sin `.pub`). Esa es tu llave privada.

## Paso 4. Aceptar la invitación

Lucy te invitará como colaborador del repositorio. Te llegará un correo de GitHub: haz clic en **Accept invitation**. Sin esto no podrás subir cambios.

## Paso 5. Descargar el proyecto

1. Crea la carpeta `C:\proyecto` (sin espacios ni tildes, y fuera de OneDrive).
2. En VS Code abre esa carpeta (*File → Open Folder*) y abre la terminal.
3. Descarga el proyecto:

   ```
   git clone git@github.com:lucyvalcarcel-blip/tech-lunch.git
   ```

4. Abre la carpeta del proyecto: *File → Open Folder* → `C:\proyecto\tech-lunch`. Arriba del explorador debe decir **TECH-LUNCH**.

## Paso 6. Instalar el proyecto

En la terminal (debe decir `PS C:\proyecto\tech-lunch>`):

```
composer run setup
```

Este comando instala todo, crea el archivo `.env`, genera la clave de la aplicación y prepara la base de datos. Tarda unos minutos.

## Paso 7. Ejecutar el proyecto

```
composer run dev
```

Abre en el navegador: **http://127.0.0.1:8000**

Para detenerlo, presiona `Ctrl + C` en la terminal.

**Si `composer run dev` da error**, usa dos terminales (botón **+** de la terminal):

- Terminal 1: `php artisan serve`
- Terminal 2: `npm run dev`

---

# Cómo trabajamos todos los días

### Antes de empezar: traer los cambios del grupo

```
git pull
```

Hazlo **siempre** antes de trabajar, para tener lo último que subieron los demás.

### Después de trabajar: guardar y subir tus cambios

```
git status
git add .
git commit -m "Describe lo que hiciste"
git push
```

### Reglas del grupo

1. **Siempre `git pull` antes de empezar** a trabajar.
2. **Mensajes de commit claros**, que digan qué hiciste:
   - ✅ `Agrega vista del menú`
   - ✅ `Corrige total del carrito`
   - ❌ `cambios`, `arreglos`, `final`
3. **Commits pequeños**: guarda y sube cada avance, no todo al final.
4. **Nunca subas el archivo `.env`** (Git ya lo ignora). Tiene datos privados.
5. **Avisa en el grupo** qué archivos vas a modificar, para no trabajar dos personas en el mismo archivo a la vez.
6. Si `git pull` o `git push` muestran un **conflicto**, no borres nada: avisa en el grupo y lo resolvemos juntos.

---

# Avance del proyecto

| Semana | Entrega | Estado |
|---|---|---|
| 10 | Primera presentación (informe, presentación y prototipo) | ✅ |
| 11 | Proyecto base en Laravel y repositorio en GitHub | ✅ |
| 13 | Segundo avance | Pendiente |
| 15 | Tercer avance | Pendiente |
| 16 | Sustentación final | Pendiente |
