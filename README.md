# EuPsi

Projeto criado com a dintenção de reunir, pisicologo e paciente aproveitando tudo de forma online,
podendo realizar a consulta de onde quiserem no conforto de suas casa 🏡; 

# Dia 13/11/2023:
## Hoje foi criado a api de ingração com o banco de dados

### Para usar o backend siga os passos a seguir:

1 - Certifique-se que vc tenha o node.js instalado caso não tenha instale a ultima versão lts no site official <a href="https://nodejs.org"> node.js;

2 - Com o node instalado, navege até a pasta backend e execute o seguinte comando no terminal do vsCode ou do seu computador:
``` bash 
# Comando para baixar os arquivos nescessarios:

$ npm install / npm i
```

3 - Com isso o seu arquivo backend está pronto para ser executado, para ver o seu funcionamento execute o seguinte comando no terminal do vsCode ou do seu computador:
``` bash 
# Comando para iniciar o servidor da api:

$ npm run satar / npm run dev

# O comando run dev irá executar um pequeno servidor de modo que cada mudaça que vc faça no backend renicie de forma automatica; 
```

# Dia 29/11/2023:
# Criação da pasta de middlewares de verrificação do token:

Caso você encontre a seguinte linha:
``` bash 
$ process.env.SECRET
```
Essa linha vem do arquivo .env localizada na pasta backend, esse arquivo é onde será
armazenado as variáveis de ambiente da sua aplicação, existe um arquivo chamado .env.example,
no mesmo diretório. Nele está uma explicaçõ de como o .env funciona, para criar o arquivo das variaveis de ambiente, basta excluir o .example do arquivo mencionado e insira o que for necessarioo.