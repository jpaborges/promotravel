#! /bin/bash
#script para instalacao das bibliotecas necessarias a rodar o crawler

echo Atualizando o ubuntu
sudo apt-get update
echo Instalando o essencial
sudo apt-get install build-essential
sudo apt-get install python
sudo apt-get install xvfb
sudo apt-get install python-setuptools
echo instalando as dependencias da biblioteca spynner
apt-cache search pyqt
sudo apt-get install python-qt4
sudo apt-get install python-lxml
sudo apt-get install libxml2-dev
sudo apt-get install libxslt-dev
sudo apt-get install git
git clone https://github.com/makinacorpus/spynner.git
cd spynner
sudo python setup.py install
