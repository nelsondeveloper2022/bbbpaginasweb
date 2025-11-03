-- Solución completa para el usuario ID 12
-- Ejecutar estos comandos en tu base de datos MySQL

-- 1. Crear el plan gratuito si no existe
INSERT INTO bbbplan (
    idPlan, 
    nombre, 
    slug, 
    descripcion, 
    precioPesos, 
    preciosDolar, 
    dias, 
    orden, 
    destacado, 
    idioma, 
    idEmpresa, 
    aplicaProductos, 
    created_at, 
    updated_at
)
VALUES (
    6, 
    'Plan Gratuito 15 días', 
    'plan-gratuito-15-dias', 
    'Plan de prueba gratuito por 15 días con todas las funcionalidades', 
    0.00, 
    0.00, 
    15, 
    0, 
    0, 
    'spanish', 
    1, 
    1, 
    NOW(), 
    NOW()
)
ON DUPLICATE KEY UPDATE 
    nombre = 'Plan Gratuito 15 días',
    dias = 15,
    aplicaProductos = 1;

-- 2. Asignar el plan gratuito al usuario
UPDATE users 
SET id_plan = 6 
WHERE id = 12;

-- 3. Verificar estado de la empresa y landing (CONSULTA DE DIAGNÓSTICO)
SELECT 
    u.id as user_id,
    u.email,
    u.id_plan,
    u.idEmpresa,
    e.nombre as empresa_nombre,
    l.id as landing_id,
    l.titulo_principal,
    l.estado as landing_estado
FROM users u
LEFT JOIN bbb_empresas e ON u.idEmpresa = e.idEmpresa
LEFT JOIN bbb_landing_pages l ON e.idEmpresa = l.empresa_id
WHERE u.id = 12;

-- 4. Si la empresa no tiene landing, crear una básica
INSERT IGNORE INTO bbb_landing_pages (
    empresa_id, 
    titulo_principal, 
    descripcion, 
    estado, 
    created_at, 
    updated_at
)
SELECT 
    15,
    'Especias Fènix',
    'Especias y condimentos de la mejor calidad para tu cocina',
    'borrador',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM bbb_landing_pages WHERE empresa_id = 15
);

-- 5. Si la landing existe pero no tiene título, actualizarlo
UPDATE bbb_landing_pages 
SET titulo_principal = 'Especias Fènix',
    descripcion = COALESCE(NULLIF(descripcion, ''), 'Especias y condimentos de la mejor calidad para tu cocina')
WHERE empresa_id = 15 
AND (titulo_principal IS NULL OR titulo_principal = '' OR TRIM(titulo_principal) = '');

-- 6. Verificación final - ejecutar esta consulta para confirmar que todo está OK
SELECT 
    'VERIFICACIÓN FINAL' as resultado,
    u.id as user_id,
    u.email,
    u.id_plan,
    p.nombre as plan_nombre,
    p.dias as plan_dias,
    u.trial_ends_at,
    u.idEmpresa,
    e.nombre as empresa_nombre,
    l.titulo_principal,
    CASE 
        WHEN u.id_plan IS NULL THEN 'ERROR: Sin plan asignado'
        WHEN u.idEmpresa IS NULL THEN 'ERROR: Sin empresa asignada'
        WHEN e.idEmpresa IS NULL THEN 'ERROR: Empresa no encontrada'
        WHEN l.id IS NULL THEN 'ERROR: Sin landing page'
        WHEN l.titulo_principal IS NULL OR l.titulo_principal = '' THEN 'ERROR: Landing sin título'
        ELSE 'TODO OK - DEBERÍA FUNCIONAR'
    END as estado_final
FROM users u
LEFT JOIN bbbplan p ON u.id_plan = p.idPlan
LEFT JOIN bbb_empresas e ON u.idEmpresa = e.idEmpresa
LEFT JOIN bbb_landing_pages l ON e.idEmpresa = l.empresa_id
WHERE u.id = 12;