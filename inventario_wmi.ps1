$patrimonio = Read-Host "Digite o numero de patrimonio do computador"

$pc = $env:COMPUTERNAME
$usuario = $env:USERNAME
$cpu = (Get-CimInstance Win32_Processor).Name
$ram = [math]::Round((Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory / 1GB)
$so = (Get-CimInstance Win32_OperatingSystem).Caption
$placaMae = (Get-CimInstance Win32_BaseBoard).Product
$bios = (Get-CimInstance Win32_BIOS).SMBIOSBIOSVersion
$os = Get-CimInstance Win32_OperatingSystem
$arquitetura = $os.OSArchitecture
$versao_so   = $os.Version
$computador = Get-CimInstance Win32_ComputerSystem
$fabricante = $computador.Manufacturer
$disco = Get-CimInstance Win32_DiskDrive | Select-Object -First 1
$disco_modelo = $disco.Model
$disco_tamanho = [Math]::Round($disco.Size / 1GB, 0)

$dados = @{
    patrimonio = $patrimonio
    pc = $pc
    usuario = $usuario
    cpu = $cpu
    ram = "$ram GB"
    so = $so
    placa_mae = $placaMae
    bios = $bios
    arquitetura = $arquitetura
    versao_so = $versao_so
    fabricante = $fabricante
    disco = "$disco_modelo - $disco_tamanho GB"

}

$url = "http://localhost/ITB - InfoPCS/ITB---InfoPCS/api/receber_maquina.php"

$response = Invoke-RestMethod -Uri $url -Method Post -Body $dados

Write-Host "=============================="
Write-Host "Resultado do envio:"
Write-Host $response
Write-Host "=============================="
