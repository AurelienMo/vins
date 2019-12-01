Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.network :forwarded_port, guest: 22, host: 2201, id: "ssh" #ssh
  config.vm.network :forwarded_port, guest: 80, host: 8001 #web
  config.vm.network :forwarded_port, guest: 3306, host: 33601 #mysql
  config.vm.network :forwarded_port, guest: 1080, host: 10801 #maildev

  config.vm.provision :shell, path: "bootstrap.sh"

  config.vm.synced_folder ".", "/var/www/html", type: "rsync",
      rsync__exclude: [".idea", ".git/", "vendor/", "node_modules/", "var/cache", "public/bundles", "var/log"]
  #config.vm.synced_folder "/Volumes/Stockage/PersonalProject/vins", "/var/www/html/config", type: 'sshfs', reverse: true
  config.vm.hostname = "vins"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2048"
    vb.cpus = "2"
  end
  config.ssh.forward_agent = true
end
